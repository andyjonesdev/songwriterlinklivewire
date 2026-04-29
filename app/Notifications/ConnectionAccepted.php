<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ConnectionAccepted extends Notification
{
    use Queueable;

    public function __construct(public readonly User $acceptor) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $name = $this->acceptor->profile?->display_name ?? $this->acceptor->name;

        return [
            'type'       => 'connection_accepted',
            'message'    => "{$name} accepted your connection request.",
            'url'        => "/members/{$this->acceptor->profile?->slug}",
            'acceptor_id'=> $this->acceptor->id,
        ];
    }
}
