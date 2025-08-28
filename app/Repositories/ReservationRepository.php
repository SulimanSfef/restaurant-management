<?php
namespace App\Repositories;

use App\Models\Reservation;
use Illuminate\Support\Collection;

class ReservationRepository
{
    public function getAllReservations()
    {
        return Reservation::all();
    }

    public function createReservation($data)
    {
        return Reservation::create($data);
    }

    public function getReservationById($id)
    {
        return Reservation::findOrFail($id);
    }

    public function updateReservation($id, $data)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->update($data);
        return $reservation;
    }

    public function deleteReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        return $reservation->delete();
    }

    public function getReservationsByTable($tableId)
    {
        return Reservation::where('table_id', $tableId)->get();
    }

    public function getReservationsForTableAndDate($tableId, $date)
    {
        return Reservation::where('table_id', $tableId)
            ->where('date', $date)
            ->get();
    }

    public function isSlotTaken($tableId, $date, array $slots)
    {
        $reservations = $this->getReservationsForTableAndDate($tableId, $date);

        foreach ($reservations as $reservation) {
            $existingSlots = json_decode($reservation->booked_slots, true);
            if (array_intersect($slots, $existingSlots)) {
                return true;
            }
        }

        return false;
    }

public function getByUser($userId)
{
    return Reservation::where('user_id', $userId)->with('table')->get();
}




}
