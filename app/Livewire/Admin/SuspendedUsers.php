<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\VerificationLog;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app', ['title' => 'Admin — Suspended Accounts'])]
class SuspendedUsers extends Component
{
    use WithPagination;

    public function reinstate(int $userId): void
    {
        $user = User::findOrFail($userId);
        $user->update([
            'status'           => 'active',
            'suspension_reason'=> null,
        ]);

        VerificationLog::create([
            'user_id' => $user->id,
            'event'   => 'account_reinstated',
            'detail'  => ['actioned_by' => auth()->id()],
        ]);
    }

    public function ban(int $userId): void
    {
        $user = User::findOrFail($userId);
        $user->update(['status' => 'banned']);

        VerificationLog::create([
            'user_id' => $user->id,
            'event'   => 'account_suspended',
            'detail'  => ['actioned_by' => auth()->id(), 'escalated_to' => 'banned'],
        ]);
    }

    public function render()
    {
        $users = User::with('profile')
            ->whereIn('status', ['suspended', 'banned'])
            ->latest()
            ->paginate(20);

        return view('livewire.admin.suspended-users', compact('users'));
    }
}
