<?php
namespace App\Repositories;

use App\Models\Order;

class OrderRepository
{
    public function getAllOrders()
    {
        return Order::all();
    }

    public function createOrder($data)
    {
        return Order::create($data);
    }

    public function getOrderById($id)
    {
        return Order::findOrFail($id);
    }

    public function updateOrder($id, $data)
    {
        $order = Order::findOrFail($id);
        $order->update($data);
        return $order;
    }

    public function deleteOrder($id)
    {
        $order = Order::findOrFail($id);
        return $order->delete();
    }
}
