<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountSuspended extends Notification
{
    use Queueable;

    public function __construct(public readonly string $reason) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your SongwriterLink account has been suspended')
            ->greeting("Hi {$notifiable->name},")
            ->line('Your SongwriterLink account has been suspended.')
            ->line("Reason: {$this->reason}")
            ->line('If you believe this is an error, please contact our support team.')
            ->action('Contact Support', url('/'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'    => 'account_suspended',
            'message' => "Your account has been suspended. Reason: {$this->reason}",
            'url'     => '/dashboard',
        ];
    }
}
