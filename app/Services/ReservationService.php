<?php

namespace App\Services;

use App\Repositories\TableRepository;
use App\Repositories\ReservationRepository;
use App\Notifications\TableReservedNotification;
use App\Models\User;

class ReservationService
{
    protected $tableRepository;
    protected $reservationRepository;

    public function __construct(
        TableRepository $tableRepository,
        ReservationRepository $reservationRepository
    ) {
        $this->tableRepository = $tableRepository;
        $this->reservationRepository = $reservationRepository;
    }

    public function getAllReservations()
    {
        return $this->reservationRepository->getAllReservations();
    }

    public function getReservationById($id)
    {
        return $this->reservationRepository->getReservationById($id);
    }

    public function updateReservation($id, $data)
    {
        return $this->reservationRepository->updateReservation($id, $data);
    }

    public function deleteReservation($id)
    {
        $reservation = $this->reservationRepository->getReservationById($id);

        if ($reservation->user_id !== auth()->id()) {
            return [
                'error' => true,
                'message' => 'You are not authorized to delete this reservation',
                'status' => 403
            ];
        }

        $table = $reservation->table;
        if ($table) {
            $table->status = 'available';
            $table->save();
        }

        $reservation->delete();

        return true;
    }

    public function getBookedTimes(array $data): array
    {
        $table = $this->tableRepository->findByNumber($data['table_number']);

        if (!$table) {
            return [
                'error' => true,
                'message' => 'Table not found',
            ];
        }

        $reservations = $this->reservationRepository
            ->getReservationsForTableAndDate($table->id, $data['date']);

        $booked = [];

        foreach ($reservations as $reservation) {
            $slots = json_decode($reservation->booked_slots, true);
            $booked = array_merge($booked, $slots);
        }

        return [
            'date' => $data['date'],
            'booked_slots' => array_values(array_unique($booked)),
        ];
    }

public function manualReserve(array $data)
{
    $table = $this->tableRepository->findByNumber($data['table_number']);

    if (!$table) {
        return ['error' => true, 'message' => 'Table not found'];
    }

    // تحقق من تعارض الحجوزات
    $existingReservations = \App\Models\Reservation::where('table_id', $table->id)
        ->where('date', $data['date'])
        ->get();

    foreach ($existingReservations as $reservation) {
        $existingSlots = json_decode($reservation->booked_slots, true);
        if (array_intersect($existingSlots, $data['booked_slots'])) {
            return ['error' => true, 'message' => 'This table is already reserved at one or more of the selected time slots.'];
        }
    }

    // ✅ إضافة user_id من المستخدم الحالي
    $userId = auth()->id();

    $reservation = $this->reservationRepository->createReservation([
        'user_id' => $userId,  // ✅ هذه السطر الجديد
        'customer_name' => $data['customer_name'],
        'phone' => $data['phone'],
        'guest_count' => $data['guest_count'],
        'table_id' => $table->id,
        'table_number' => $table->table_number,
        'date' => $data['date'],
        'booked_slots' => json_encode($data['booked_slots']),
        'status' => 'confirmed',
        'notes' => $data['notes']
    ]);

    $table->status = 'reserved';
    $table->save();

    // إشعار النادلين
    $waiters = \App\Models\User::where('role', 'waiter')->get();
    foreach ($waiters as $waiter) {
        $waiter->notify(new \App\Notifications\TableReservedNotification($reservation));
    }

    $reservation->load('table');

    return $reservation;
}


public function cancelReservation($id)
{
    $reservation = $this->reservationRepository->getReservationById($id);

    // تحقق من وجود الحجز
    if (!$reservation) {
        return ['error' => true, 'message' => 'Reservation not found'];
    }

    // ✅ تحقق أن المستخدم الحالي هو صاحب الحجز
    if ($reservation->user_id !== auth()->id()) {
        return ['error' => true, 'message' => 'You are not authorized to cancel this reservation'];
    }

    // ✅ تغيير حالة الطاولة إلى "available"
    $table = $reservation->table;
    if ($table) {
        $table->status = 'available';
        $table->save();
    }

    // ✅ حذف الحجز نهائيًا
    $reservation->delete();

    return ['success' => true];
}

public function getByUser($userId)
{
    return $this->reservationRepository->getByUser($userId);
}





}
