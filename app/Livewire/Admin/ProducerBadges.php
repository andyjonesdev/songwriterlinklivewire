<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\VerificationLog;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app', ['title' => 'Admin — Producer Badges'])]
class ProducerBadges extends Component
{
    use WithPagination;

    public string $filter = 'pending';

    public function grant(int $userId): void
    {
        $user = User::findOrFail($userId);
        $user->update([
            'producer_verified'    => true,
            'producer_badge_status'=> 'approved',
        ]);

        VerificationLog::create([
            'user_id' => $user->id,
            'event'   => 'producer_badge_granted',
            'detail'  => ['actioned_by' => auth()->id()],
        ]);

        $this->resetPage();
    }

    public function reject(int $userId): void
    {
        User::findOrFail($userId)->update(['producer_badge_status' => 'rejected']);
        $this->resetPage();
    }

    public function render()
    {
        $users = User::with('profile')
            ->when(
                $this->filter === 'pending',
                fn ($q) => $q->where('producer_badge_status', 'pending'),
                fn ($q) => $q->whereIn('producer_badge_status', ['approved', 'rejected'])
            )
            ->latest()
            ->paginate(20);

        return view('livewire.admin.producer-badges', compact('users'));
    }
}
