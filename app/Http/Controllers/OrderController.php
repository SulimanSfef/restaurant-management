<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderByWaiterRequest;
use App\Http\Requests\UserOrderRequest;
use App\Services\OrderService;
use App\Traits\ApiResponseTrait;

class OrderController extends Controller
{
    use ApiResponseTrait;

    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    // ✅ إنشاء طلب بواسطة النادل
    public function storeByWaiter(OrderByWaiterRequest $request)
    {
        $data = $request->validated();

        if ($this->orderService->getActiveOrderByTable($data['table_id'])) {
            return $this->errorResponse('هذه الطاولة لديها طلب نشط بالفعل.', 403);
        }

        $data['user_id'] = auth()->id();

        $order = $this->orderService->createOrderByWaiter($data);

        return $this->successResponse($order, 'تم إنشاء الطلب بواسطة النادل بنجاح', 201);
    }

    // ✅ إنشاء طلب بواسطة المستخدم
    public function store(UserOrderRequest $request)
    {
        $user = auth()->user();
        $data = $request->validated();

        $order = $this->orderService->createUserOrder(
            $user->id,
            null,
            $data['address_id'],
            $data['items']
        );

        return $this->successResponse($order, 'تم إنشاء الطلب بنجاح', 201);
    }

    // ✅ إلغاء الطلب بواسطة النادل
    public function cancel_Waiter($id)
    {
        if (auth()->user()->role !== 'waiter') {
            return $this->errorResponse(null, 'You are not authorized to cancel this order', 403);
        }

        $result = $this->orderService->cancelOrder($id);

        if (!$result) {
            return $this->errorResponse(null, 'Order not found', 404);
        }

        return $this->successResponse(null, 'Order cancelled successfully');
    }

    // ✅ تغيير حالة الطلبات
    public function markAsRequested($id)
    {
        try {
            $order = $this->orderService->markAsRequested($id);
            return $this->successResponse($order, 'Order has been requested successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    public function markAsPreparing($id)
    {
        try {
            $order = $this->orderService->markAsPreparing($id);
            return $this->successResponse($order, 'Order is now being prepared');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    public function markAsOnTheWay($id)
    {
        try {
            $order = $this->orderService->markAsOnTheWay($id);
            return $this->successResponse($order, 'Order is on the way');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    public function markAsPaid($id)
    {
        try {
            $order = $this->orderService->markAsPaid($id);
            return $this->successResponse($order, 'Order has been paid successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }
}
