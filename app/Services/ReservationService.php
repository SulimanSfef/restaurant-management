<?php
namespace App\Services;

use App\Repositories\ReservationRepository;

class ReservationService
{
    protected $reservationRepository;

    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    public function getAllReservations()
    {
        return $this->reservationRepository->getAllReservations();
    }

    public function createReservation($data)
    {
        return $this->reservationRepository->createReservation($data);
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
        return $this->reservationRepository->deleteReservation($id);
    }
}

