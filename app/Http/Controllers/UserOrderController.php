<?php

namespace App\Http\Controllers;

use App\Services\UserOrderService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class UserOrderController extends Controller
{
    use ApiResponseTrait;

    protected $userOrderService;

    public function __construct()
    {
        $this->userOrderService = new UserOrderService();
    }

    public function getMyOrders()
    {
        $userId = auth()->id();

        $orders = $this->userOrderService->getOrdersByUser($userId)
            ->where('status', 'pending')
            ->values();

        if ($orders->isEmpty()) {
            return $this->errorResponse('No pending orders found for this user.', 404);
        }

        return $this->successResponse($orders, 'Pending orders retrieved successfully');
    }

    public function getOrderStatus(Request $request, $id)
    {
        $userId = $request->user()->id;

        $status = $this->userOrderService->getOrderStatus($userId, $id);

        if (!$status) {
            return $this->errorResponse('This order does not belong to you or not found.', 404);
        }

        return $this->successResponse(['status' => $status], 'Order status fetched successfully.');
    }

    /**
     * Cancel (delete) a user order completely
     */
    public function cancelOrder(Request $request, $id)
    {
        $userId = $request->user()->id;

        $deleted = $this->userOrderService->cancelOrder($userId, $id);

        if (!$deleted) {
            return $this->errorResponse('This order does not belong to you or not found.', 404);
        }

        return $this->successResponse(null, 'Order cancelled and deleted successfully.');
    }
}
