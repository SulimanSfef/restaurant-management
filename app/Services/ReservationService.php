<?php

namespace App\Services;

use App\Repositories\ReservationRepository;
use App\Traits\ApiResponseTrait;

class ReservationService
{
    use ApiResponseTrait;

    protected $reservationRepository;

    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    public function getAllReservations()
    {
        return $this->successResponse($this->reservationRepository->getAllReservations());
    }

    public function createReservation($data)
    {
        $existing = $this->reservationRepository->findByTableAndTime($data['table_id'], $data['reserved_at']);

        if ($existing) {
            return $this->errorResponse('This table is already reserved at the selected time.', 409);
        }
        $data['status'] = 'confirmed';

        $reservation = $this->reservationRepository->createReservation($data);
        return $this->successResponse($reservation, 'Reservation created successfully.', 201);
    }

    public function getReservationById($id)
    {
        $reservation = $this->reservationRepository->getReservationById($id);
        return $this->successResponse($reservation);
    }

    public function updateReservation($id, $data)
    {
        // تأكد من أن الحجز الجديد لا يتعارض مع حجز آخر (باستثناء نفسه)
        $existing = $this->reservationRepository->findByTableAndTime($data['table_id'], $data['reserved_at']);

        if ($existing && $existing->id != $id) {
            return $this->errorResponse('This table is already reserved at the selected time.', 409);
        }

        $reservation = $this->reservationRepository->updateReservation($id, $data);
        return $this->successResponse($reservation, 'Reservation updated successfully.');
    }

    public function deleteReservation($id)
    {
        $this->reservationRepository->deleteReservation($id);
        return $this->successResponse(null, 'Reservation deleted successfully.', 204);
    }
}


