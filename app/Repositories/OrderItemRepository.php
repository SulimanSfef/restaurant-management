<?php

namespace App\Repositories;

use App\Models\OrderItem;

class OrderItemRepository
{
     public function create(array $data)
    {
        return OrderItem::create($data);
    }

    public function getByOrder($orderId)
    {
        return OrderItem::where('order_id', $orderId)->with('menuItem')->get();
    }
}
