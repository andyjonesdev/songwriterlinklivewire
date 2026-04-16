<?php

namespace App\Livewire\Messages;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Inbox extends Component
{
    public function render()
    {
        $conversations = auth()->user()->conversations()
            ->with(['participants', 'latestMessage'])
            ->get()
            ->sortByDesc(fn ($c) => optional($c->latestMessage)->created_at)
            ->values();

        // Annotate each conversation with the "other" participant and unread status
        $userId = auth()->id();
        $items  = $conversations->map(function ($conversation) use ($userId) {
            $other  = $conversation->participants->firstWhere('id', '!=', $userId);
            $pivot  = $conversation->participants->firstWhere('id', $userId)?->pivot;
            $lastReadAt = $pivot?->last_read_at;
            $latest = $conversation->latestMessage;

            $unread = $latest
                && $latest->sender_id !== $userId
                && ($lastReadAt === null || $latest->created_at > $lastReadAt);

            return (object) [
                'conversation' => $conversation,
                'other'        => $other,
                'latest'       => $latest,
                'unread'       => $unread,
            ];
        });

        return view('livewire.messages.inbox', compact('items'));
    }
}
