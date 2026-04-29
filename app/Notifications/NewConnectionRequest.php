<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewConnectionRequest extends Notification
{
    use Queueable;

    public function __construct(public readonly User $requester) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $name = $this->requester->profile?->display_name ?? $this->requester->name;

        return [
            'type'         => 'connection_request',
            'message'      => "{$name} sent you a connection request.",
            'url'          => "/members/{$this->requester->profile?->slug}",
            'requester_id' => $this->requester->id,
        ];
    }
}
