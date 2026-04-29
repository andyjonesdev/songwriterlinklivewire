<?php

namespace App\Notifications;

use App\Models\BriefApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BriefApplicationReceived extends Notification
{
    use Queueable;

    public function __construct(public readonly BriefApplication $application) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $applicantName = $this->application->applicant?->profile?->display_name
            ?? $this->application->applicant?->name
            ?? 'Someone';

        return [
            'type'       => 'brief_application',
            'message'    => "{$applicantName} applied to your brief: "{$this->application->brief?->title}"",
            'url'        => "/briefs/{$this->application->brief_id}",
            'brief_id'   => $this->application->brief_id,
            'applicant_id' => $this->application->applicant_id,
        ];
    }
}
