<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManualReserveRequest;
use App\Http\Requests\GetBookedSlotsRequest;
use App\Http\Requests\BookedTimesRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Services\ReservationService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;


class ReservationController extends Controller
{
    use ApiResponseTrait;

    protected $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    // ✅ عرض كل الحجوزات (للمشرف مثلاً)
    public function index()
    {
        $reservations = $this->reservationService->getAllReservations();
        return $this->successResponse($reservations);
    }


    // ✅ عرض حجز حسب الـ ID
    public function show($id)
    {
        $reservation = $this->reservationService->getReservationById($id);
        return $this->successResponse($reservation);
    }

    // ✅ تعديل حجز
    public function update(UpdateReservationRequest $request, $id)
    {
        $result = $this->reservationService->updateReservation($id, $request->validated());

        if (is_array($result) && isset($result['error'])) {
            return $this->errorResponse($result['message'], $result['status']);
        }

        return $this->successResponse($result, 'Reservation updated successfully.');
    }

    // ✅ حذف حجز
    public function destroy($id)
    {
        $this->reservationService->deleteReservation($id);
        return $this->successResponse(null, 'Reservation deleted successfully.', 204);
    }

public function cancel($id)
{
    $result = $this->reservationService->cancelReservation($id);

    if (isset($result['error'])) {
        return $this->errorResponse($result['message'], 403);
    }

    return $this->successResponse(null, 'Reservation canceled and deleted successfully');
}


public function manualReserve(ManualReserveRequest $request)
{
    $result = $this->reservationService->manualReserve($request->validated());

    if (isset($result['error'])) {
        return $this->errorResponse($result['message'], 409);
    }

    return $this->successResponse($result, 'Reservation created successfully');
}


public function getBookedSlots(GetBookedSlotsRequest $request)
{
    $data = $request->validated();
    $result = $this->reservationService->getBookedTimes($data);

    if (isset($result['error'])) {
        return $this->errorResponse($result['message'], 404);
    }

    return $this->successResponse($result, 'Booked slots fetched successfully');
}

public function getUserReservations(Request $request)
{
    $user = $request->user();

    $reservations = $this->reservationService->getByUser($user->id);

    return response()->json([
        'status' => true,
        'message' => 'User reservations fetched successfully.',
        'data' => $reservations
    ]);
}




}
