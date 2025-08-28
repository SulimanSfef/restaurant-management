<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository
{
    protected Order $model;

    public function __construct(?Order $order = null)
    {
        $this->model = $order ?? new Order();
    }

    public function getActiveOrderByTable(int $tableId)
    {
        return $this->model->newQuery()
            ->where('table_id', $tableId)
            ->whereNotIn('status', ['served', 'paid', 'cancelled'])
            ->first();
    }

    public function find(int $id)
    {
        return $this->model->with('items.menuItem', 'address')->findOrFail($id);
    }

    public function delete($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return false;
        }
        return $order->delete();
    }

    public function findById(int $id)
    {
        return $this->model->newQuery()
            ->with('items.menuItem')
            ->findOrFail($id);
    }

    public function createOrderWithItems(int $userId, ?int $tableId, ?int $addressId, array $items)
    {
        $totalPrice = 0;

        foreach ($items as $item) {
            $menuItem = \App\Models\MenuItem::findOrFail($item['menu_item_id']);
            $totalPrice += $menuItem->price * $item['quantity'];
        }

        $order = $this->model->create([
            'user_id'     => $userId,
            'table_id'    => $tableId,
            'address_id'  => $addressId,
            'status'      => 'requested',
            'final_price' => $totalPrice,
        ]);

        foreach ($items as $item) {
            $order->items()->create([
                'menu_item_id' => $item['menu_item_id'],
                'quantity'     => $item['quantity'],
                'note'         => $item['note'] ?? null,
            ]);
        }

        return $order->load('items.menuItem');
    }
}
