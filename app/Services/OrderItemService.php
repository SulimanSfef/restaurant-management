<?php

namespace App\Services;

use App\Repositories\OrderItemRepository;

class OrderItemService
{
    protected $orderItemRepo;

    public function __construct()
    {
        $this->orderItemRepo = new OrderItemRepository();
    }

    public function addItem(array $data)
    {
        return $this->orderItemRepo->create($data);
    }

    public function getItemsByOrder($orderId)
    {
        return $this->orderItemRepo->getByOrder($orderId);
    }
}
