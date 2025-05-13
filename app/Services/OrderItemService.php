<?php

namespace App\Services;

use App\Repositories\OrderItemRepository;

class OrderItemService
{
    protected $orderItemRepository;

    public function __construct(OrderItemRepository $orderItemRepository)
    {
        $this->orderItemRepository = $orderItemRepository;
    }

    public function getAllOrderItems()
    {
        return $this->orderItemRepository->getAllOrderItems();
    }

    public function createOrderItem($data)
    {
        return $this->orderItemRepository->createOrderItem($data);
    }

    public function getOrderItemById($id)
    {
        return $this->orderItemRepository->getOrderItemById($id);
    }

    public function updateOrderItem($id, $data)
    {
        return $this->orderItemRepository->updateOrderItem($id, $data);
    }

    public function deleteOrderItem($id)
    {
        return $this->orderItemRepository->deleteOrderItem($id);
    }
}
