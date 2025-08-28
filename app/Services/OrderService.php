<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use App\Repositories\OrderItemRepository;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use App\Notifications\OrderStatusChangedNotification;

class OrderService
{
    protected OrderRepository $orderRepository;
    protected OrderItemRepository $orderItemRepo;

    public function __construct()
    {
        $this->orderRepository = new OrderRepository();
        $this->orderItemRepo   = new OrderItemRepository();
    }

    public function getActiveOrderByTable(int $tableId)
    {
        return $this->orderRepository->getActiveOrderByTable($tableId);
    }

    // ✅ إنشاء طلب بواسطة النادل
    public function createOrderByWaiter(array $data)
    {
        return DB::transaction(function () use ($data) {
            $order = $this->orderRepository->createOrderWithItems(
                $data['user_id'],
                $data['table_id'],
                null,
                $data['items']
            );

            // إرسال إشعار للشيف
            $chef = User::where('role', 'chef')->first();
            if ($chef) {
                $chef->notify(new NewOrderNotification($order));
            }

            return $order;
        });
    }

    // ✅ إنشاء طلب بواسطة المستخدم
    public function createUserOrder(int $userId, ?int $tableId, ?int $addressId, array $items)
    {
        return DB::transaction(function () use ($userId, $tableId, $addressId, $items) {
            $order = $this->orderRepository->createOrderWithItems($userId, $tableId, $addressId, $items);

            // إرسال إشعار للشيف
            $chef = User::where('role', 'chef')->first();
            if ($chef) {
                $chef->notify(new NewOrderNotification($order));
            }

            return $order;
        });
    }

    public function cancelOrder($id)
    {
        return $this->orderRepository->delete($id);
    }

    // ✅ تحديثات الحالة مع إشعار للنادل
    public function markAsRequested($id)
    {
        $order = $this->orderRepository->findById($id);
        $order->status = 'requested';
        $order->save();

        $this->notifyWaiter($order, 'تم استلام الطلب');
        return $order;
    }

    public function markAsPreparing($id)
    {
        $order = $this->orderRepository->findById($id);
        $order->status = 'preparing';
        $order->save();

        $this->notifyWaiter($order, 'الطلب قيد التحضير');
        return $order;
    }

    public function markAsOnTheWay($id)
    {
        $order = $this->orderRepository->findById($id);
        $order->status = 'on_the_way';
        $order->save();

        $this->notifyWaiter($order, 'الطلب في الطريق');
        return $order;
    }

    public function markAsPaid($id)
    {
        $order = $this->orderRepository->findById($id);
        $order->status = 'paid';
        $order->save();

        $this->notifyWaiter($order, 'تم دفع الطلب');
        return $order;
    }

    // ✅ دالة مساعدة لإشعار النادل
    private function notifyWaiter($order, $message)
    {
        $waiter = User::where('role', 'waiter')->first();
        if ($waiter) {
            $waiter->notify(new OrderStatusChangedNotification($order, $message));
        }
    }
}
