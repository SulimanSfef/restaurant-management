<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OrderItemService;

class OrderItemController extends Controller
{
    protected $orderItemService;

    public function __construct(OrderItemService $orderItemService)
    {
        $this->orderItemService = $orderItemService;
    }

    // إضافة صنف لطلب
    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string'
        ]);

        $item = $this->orderItemService->addItem($data);

        return response()->json($item, 201);
    }

    // جلب كل الأصناف التابعة لطلب معين
    public function getByOrder($orderId)
    {
        $items = $this->orderItemService->getItemsByOrder($orderId);
        return response()->json($items);
    }
}
