<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountVerified extends Notification
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your SongwriterLink identity has been verified')
            ->greeting("Hi {$notifiable->name},")
            ->line('Great news — your identity verification has been approved.')
            ->line('Your profile is now live and you can start connecting with other verified members.')
            ->action('Go to your profile', url('/dashboard'))
            ->line('Welcome to the community!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'    => 'account_verified',
            'message' => 'Your identity has been verified. Your profile is now live.',
            'url'     => '/dashboard',
        ];
    }
}
