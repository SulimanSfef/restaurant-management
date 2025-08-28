<?php

namespace App\Services;

use App\Repositories\UserOrderRepository;
use App\Repositories\OrderItemRepository;
use Illuminate\Support\Facades\DB;


class UserOrderService
{
    protected $userOrderRepository;
    protected $orderItemRepo;

    public function __construct()
    {
        $this->userOrderRepository = new UserOrderRepository();
        $this->orderItemRepo = new OrderItemRepository();
    }

    public function getOrdersByUser($userId)
    {
        return $this->userOrderRepository->getOrdersByUser($userId);
    }

    public function getOrderStatus($userId, $orderId)
    {
        return $this->userOrderRepository->getOrderStatus($userId, $orderId);
    }

    public function cancelOrder($userId, $orderId)
    {
        return $this->userOrderRepository->deleteOrder($userId, $orderId);
    }


  
}
