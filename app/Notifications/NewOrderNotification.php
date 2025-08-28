<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    use Queueable;

    private $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['database']; // نخزن في قاعدة البيانات
    }

    public function toDatabase($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'message'  => "📦 طلب جديد رقم #{$this->order->id} بانتظار التحضير",
        ];
    }
}
