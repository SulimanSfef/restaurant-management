<?php
namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordApiNotification extends ResetPassword
{
    public function toMail($notifiable)
    {
        $resetUrl = config('app.frontend_url') . '/reset-password?token=' . $this->token . '&email=' . urlencode($notifiable->email);

        return (new MailMessage)
            ->subject('إعادة تعيين كلمة المرور')
            ->line('لقد طلبت إعادة تعيين كلمة المرور لحسابك.')
            ->action('إعادة تعيين كلمة المرور', $resetUrl)
            ->line('إذا لم تطلب ذلك، فلا حاجة لأي إجراء.');
    }
}
