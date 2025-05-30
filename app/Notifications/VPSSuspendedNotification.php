<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VPSSuspendedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('VPS Anda Telah Di-Suspend')
                    ->greeting('Halo ' . $notifiable->name . ',')
                    ->line('Kami informasikan bahwa VPS Anda telah di-suspend karena saldo tidak mencukupi.')
                    ->line('Silakan isi ulang saldo Anda untuk mengaktifkan kembali layanan.')
                    ->line('Terima kasih telah menggunakan layanan kami.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
       public function toDatabase($notifiable)
    {
        return [
            'message' => 'VPS Anda telah di-suspend karena saldo tidak mencukupi. Silakan isi ulang saldo Anda.',
        ];
    }
}
