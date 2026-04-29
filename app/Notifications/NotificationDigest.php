<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;

class NotificationDigest extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly Collection $unreadNotifications
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $count = $this->unreadNotifications->count();
        $name  = $notifiable->profile?->display_name ?? $notifiable->name;

        $mail = (new MailMessage)
            ->subject("You have {$count} unread notification" . ($count !== 1 ? 's' : '') . ' on SongwriterLink')
            ->greeting("Hi {$name},")
            ->line("You have **{$count}** unread notification" . ($count !== 1 ? 's' : '') . ' waiting for you on SongwriterLink.');

        foreach ($this->unreadNotifications->take(8) as $notification) {
            $data    = $notification->data;
            $message = $data['message'] ?? 'You have a new notification.';
            $mail->line('• ' . $message);
        }

        if ($count > 8) {
            $mail->line('… and ' . ($count - 8) . ' more.');
        }

        $mail
            ->action('View Notifications', url(route('notifications')))
            ->line('You can manage your notification preferences in your account settings.')
            ->salutation('— The SongwriterLink Team');

        return $mail;
    }
}
