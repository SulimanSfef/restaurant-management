<?php
namespace App\Repositories;

use App\Models\Reservation;

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
}

