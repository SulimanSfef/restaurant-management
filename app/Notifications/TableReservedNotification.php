<?php

namespace App\Notifications;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;

class TableReservedNotification extends Notification
{
    use Queueable;

    protected $reservation;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    public function via($notifiable)
    {
        return ['database']; // تخزين في قاعدة البيانات
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'تم حجز الطاولة رقم ' . $this->reservation->table->table_number .
                         ' من قبل ' . $this->reservation->customer_name,
            'table_id' => $this->reservation->table_id,
            'customer_name' => $this->reservation->customer_name,
            'date' => $this->reservation->date,
            'booked_slots' => $this->reservation->booked_slots,
        ];
    }
}
