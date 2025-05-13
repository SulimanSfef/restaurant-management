<?php

namespace App\Repositories;

use App\Models\OrderItem;

class OrderItemRepository
{
    public function getAllOrderItems()
    {
        return OrderItem::all();
    }

    public function createOrderItem($data)
    {
        return OrderItem::create($data);
    }

    public function getOrderItemById($id)
    {
        return OrderItem::findOrFail($id);
    }

    public function updateOrderItem($id, $data)
    {
        $orderItem = OrderItem::findOrFail($id);
        $orderItem->update($data);
        return $orderItem;
    }

    public function deleteOrderItem($id)
    {
        $orderItem = OrderItem::findOrFail($id);
        return $orderItem->delete();
    }
}
