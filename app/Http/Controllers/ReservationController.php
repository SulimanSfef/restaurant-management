<?php
namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Services\ReservationService;

class ReservationController extends Controller
{
    protected $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    // للحصول على جميع الحجوزات
    public function index()
    {
        return response()->json($this->reservationService->getAllReservations());
    }

    // لإنشاء حجز جديد
    public function store(ReservationRequest $request)
    {
        return response()->json($this->reservationService->createReservation($request->validated()));
    }

    // للحصول على تفاصيل حجز معين
    public function show($id)
    {
        return response()->json($this->reservationService->getReservationById($id));
    }

    // لتحديث الحجز
    public function update(ReservationRequest $request, $id)
    {
        return response()->json($this->reservationService->updateReservation($id, $request->validated()));
    }

    // لحذف الحجز
    public function destroy($id)
    {
        return response()->json($this->reservationService->deleteReservation($id), 204);
    }
}
