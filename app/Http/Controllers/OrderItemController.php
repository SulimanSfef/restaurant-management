<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderItemRequest;
use App\Services\OrderItemService;

class OrderItemController extends Controller
{
    protected $orderItemService;

    public function __construct(OrderItemService $orderItemService)
    {
        $this->orderItemService = $orderItemService;
    }

    // للحصول على جميع العناصر في الطلب
    public function index()
    {
        return response()->json($this->orderItemService->getAllOrderItems());
    }

    // لإنشاء عنصر جديد في الطلب
    public function store(OrderItemRequest $request)
    {
        return response()->json($this->orderItemService->createOrderItem($request->validated()), 201);
    }

    // للحصول على تفاصيل عنصر معين في الطلب
    public function show($id)
    {
        return response()->json($this->orderItemService->getOrderItemById($id));
    }

    // لتحديث عنصر في الطلب
    public function update(OrderItemRequest $request, $id)
    {
        return response()->json($this->orderItemService->updateOrderItem($id, $request->validated()));
    }

    // لحذف عنصر من الطلب
    public function destroy($id)
    {
        return response()->json($this->orderItemService->deleteOrderItem($id), 204);
    }
}
