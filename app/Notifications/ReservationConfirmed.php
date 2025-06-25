<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReservationConfirmed extends Notification
{
    use Queueable;

    protected $reservation;

    public function __construct($reservation)
    {
        $this->reservation = $reservation;
    }

    public function via($notifiable)
    {
        return ['mail']; // يمكنك لاحقًا دعم SMS أو Database
    }

    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('Reservation Confirmed')
            ->greeting('Hello ' . $this->reservation->customer_name)
            ->line('Your reservation is confirmed.')
            ->line('Table Number: ' . $this->reservation->table_id)
            ->line('Date & Time: ' . $this->reservation->reserved_at)
            ->line('Status: ' . $this->reservation->status)
            ->line('Thank you for using our restaurant service!');
    }
}

