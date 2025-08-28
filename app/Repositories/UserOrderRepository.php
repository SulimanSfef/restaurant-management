<?php

namespace App\Repositories;

use App\Models\Order;

class UserOrderRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Order();
    }

    public function getOrdersByUser($userId)
    {
        return $this->model->where('user_id', $userId)
            ->with('items.menuItem')
            ->get();
    }

    public function getOrderStatus($userId, $orderId)
    {
        $order = $this->model->newQuery()
            ->where('user_id', $userId)
            ->where('id', $orderId)
            ->first();

        return $order ? $order->status : null;
    }

    public function deleteOrder($userId, $orderId)
    {
        $order = $this->model->newQuery()
            ->where('user_id', $userId)
            ->where('id', $orderId)
            ->first();

        if (!$order) {
            return false;
        }

        // حذف العناصر المرتبطة (Cascade إذا معرف بعلاقة في DB)
        $order->items()->delete();

        // حذف الطلب نفسه
        $order->delete();

        return true;
    }









}
