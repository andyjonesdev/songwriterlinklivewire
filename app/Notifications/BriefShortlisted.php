<?php

namespace App\Notifications;

use App\Models\BriefApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BriefShortlisted extends Notification
{
    use Queueable;

    public function __construct(public readonly BriefApplication $application) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $briefTitle = $this->application->brief?->title ?? 'a brief';

        return (new MailMessage)
            ->subject("You've been shortlisted!")
            ->greeting("Hi {$notifiable->name},")
            ->line("Great news — you've been shortlisted for the brief: \"{$briefTitle}\".")
            ->line('The poster has marked your application as a top candidate.')
            ->action('View brief', url("/briefs/{$this->application->brief_id}"));
    }

    public function toArray(object $notifiable): array
    {
        $briefTitle = $this->application->brief?->title ?? 'a brief';

        return [
            'type'     => 'brief_shortlisted',
            'message'  => "You've been shortlisted for: \"{$briefTitle}\"",
            'url'      => "/briefs/{$this->application->brief_id}",
            'brief_id' => $this->application->brief_id,
        ];
    }
}
