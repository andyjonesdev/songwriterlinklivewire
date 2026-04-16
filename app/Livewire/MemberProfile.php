<?php

namespace App\Livewire;

use App\Models\Connection;
use App\Models\Conversation;
use App\Models\PortfolioItem;
use App\Models\Profile;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class MemberProfile extends Component
{
    public Profile $profile;

    // 'own' | 'none' | 'pending_sent' | 'pending_received' | 'connected'
    public string $connectionStatus = 'none';

    public function mount(Profile $profile): void
    {
        $this->profile = $profile;

        // Increment view count (not counted for own profile)
        if (! auth()->check() || auth()->id() !== $profile->user_id) {
            $profile->increment('views_count');
        }

        $this->refreshConnectionStatus();
    }

    // ── Connection helpers ────────────────────────────────────────────────────

    private function refreshConnectionStatus(): void
    {
        if (! auth()->check()) {
            $this->connectionStatus = 'none';
            return;
        }

        $authId    = auth()->id();
        $profileId = $this->profile->user_id;

        if ($authId === $profileId) {
            $this->connectionStatus = 'own';
            return;
        }

        $connection = Connection::where(function ($q) use ($authId, $profileId) {
            $q->where('requester_id', $authId)->where('recipient_id', $profileId);
        })->orWhere(function ($q) use ($authId, $profileId) {
            $q->where('requester_id', $profileId)->where('recipient_id', $authId);
        })->first();

        if (! $connection) {
            $this->connectionStatus = 'none';
        } elseif ($connection->status === 'accepted') {
            $this->connectionStatus = 'connected';
        } elseif ($connection->status === 'pending') {
            $this->connectionStatus = $connection->requester_id === $authId
                ? 'pending_sent'
                : 'pending_received';
        } else {
            $this->connectionStatus = 'none';
        }
    }

    public function sendConnectionRequest(): void
    {
        if (! auth()->check() || ! auth()->user()->isActive()) return;

        $authId    = auth()->id();
        $profileId = $this->profile->user_id;

        $existing = Connection::where(function ($q) use ($authId, $profileId) {
            $q->where('requester_id', $authId)->where('recipient_id', $profileId);
        })->orWhere(function ($q) use ($authId, $profileId) {
            $q->where('requester_id', $profileId)->where('recipient_id', $authId);
        })->first();

        if (! $existing) {
            Connection::create([
                'requester_id' => $authId,
                'recipient_id' => $profileId,
                'status'       => 'pending',
            ]);
        }

        $this->refreshConnectionStatus();
    }

    public function acceptConnection(): void
    {
        if (! auth()->check()) return;

        Connection::where('requester_id', $this->profile->user_id)
            ->where('recipient_id', auth()->id())
            ->where('status', 'pending')
            ->update(['status' => 'accepted']);

        // Update connection counts on both profiles
        $this->profile->increment('connections_count');
        auth()->user()->profile?->increment('connections_count');

        $this->refreshConnectionStatus();
    }

    public function removeConnection(): void
    {
        if (! auth()->check()) return;

        $authId    = auth()->id();
        $profileId = $this->profile->user_id;

        $connection = Connection::where(function ($q) use ($authId, $profileId) {
            $q->where('requester_id', $authId)->where('recipient_id', $profileId);
        })->orWhere(function ($q) use ($authId, $profileId) {
            $q->where('requester_id', $profileId)->where('recipient_id', $authId);
        })->first();

        if ($connection) {
            if ($connection->status === 'accepted') {
                $this->profile->decrement('connections_count');
                auth()->user()->profile?->decrement('connections_count');
            }
            $connection->delete();
        }

        $this->refreshConnectionStatus();
    }

    public function startMessage(): void
    {
        if (! auth()->check() || ! auth()->user()->isActive()) {
            $this->redirect(route('login'));
            return;
        }

        $authId    = auth()->id();
        $profileId = $this->profile->user_id;

        // Rate limit: 20 new conversation starts per day
        $rateLimiter = app(\Illuminate\Cache\RateLimiter::class);
        $rateKey     = "new_convo:{$authId}";

        // Find existing 1:1 conversation
        $conversation = auth()->user()->conversations()
            ->whereHas('participants', fn ($q) => $q->where('user_id', $profileId))
            ->first();

        if (! $conversation) {
            if ($rateLimiter->tooManyAttempts($rateKey, 20)) {
                session()->flash('error', 'You can only start 20 new conversations per day. Try again tomorrow.');
                return;
            }
            $rateLimiter->hit($rateKey, 86400);

            $conversation = Conversation::create();
            $conversation->participants()->attach([$authId, $profileId]);
        }

        $this->redirect(route('messages.show', $conversation));
    }

    // ── Render ────────────────────────────────────────────────────────────────

    public function render()
    {
        $portfolioItems = PortfolioItem::where('user_id', $this->profile->user_id)
            ->where('is_public', true)
            ->latest()
            ->get();

        $canSeeSocialLinks = auth()->check() && (
            auth()->id() === $this->profile->user_id
            || auth()->user()->isProPlus()
            || $this->connectionStatus === 'connected'
        );

        return view('livewire.member-profile', compact('portfolioItems', 'canSeeSocialLinks'));
    }
}
