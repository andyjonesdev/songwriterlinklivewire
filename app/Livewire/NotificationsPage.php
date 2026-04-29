<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Notifications'])]
class NotificationsPage extends Component
{
    public function markAllRead(): void
    {
        auth()->user()->unreadNotifications->markAsRead();
    }

    public function markRead(string $id): void
    {
        auth()->user()->notifications()->where('id', $id)->update(['read_at' => now()]);
    }

    public function delete(string $id): void
    {
        auth()->user()->notifications()->where('id', $id)->delete();
    }

    public function render()
    {
        $notifications = auth()->user()->notifications()->latest()->paginate(30);

        return view('livewire.notifications-page', compact('notifications'));
    }
}
