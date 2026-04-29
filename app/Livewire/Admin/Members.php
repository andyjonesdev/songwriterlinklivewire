<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\VerificationLog;
use App\Notifications\AccountSuspended;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app', ['title' => 'Admin — Members'])]
class Members extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $statusFilter = '';

    #[Url]
    public string $tierFilter = '';

    public function updatedSearch(): void  { $this->resetPage(); }
    public function updatedStatusFilter(): void { $this->resetPage(); }
    public function updatedTierFilter(): void { $this->resetPage(); }

    public function suspend(int $userId): void
    {
        $user = User::findOrFail($userId);
        $user->update(['status' => 'suspended', 'suspension_reason' => 'Suspended by admin.']);

        VerificationLog::create([
            'user_id' => $user->id,
            'event'   => 'account_suspended',
            'detail'  => ['actioned_by' => auth()->id()],
        ]);

        $user->notify(new AccountSuspended('Your account has been suspended by an administrator.'));
    }

    public function reinstate(int $userId): void
    {
        $user = User::findOrFail($userId);
        $user->update(['status' => 'active', 'suspension_reason' => null]);

        VerificationLog::create([
            'user_id' => $user->id,
            'event'   => 'account_reinstated',
            'detail'  => ['actioned_by' => auth()->id()],
        ]);
    }

    public function render()
    {
        $users = User::with('profile')
            ->when($this->search, function ($q) {
                $q->where(fn ($q2) =>
                    $q2->where('name', 'like', "%{$this->search}%")
                       ->orWhere('email', 'like', "%{$this->search}%")
                );
            })
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->when($this->tierFilter, fn ($q) => $q->where('subscription_tier', $this->tierFilter))
            ->latest()
            ->paginate(25);

        return view('livewire.admin.members', compact('users'));
    }
}
