<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\VerificationLog;
use App\Notifications\AccountVerified;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app', ['title' => 'Admin — Verification Queue'])]
class VerificationQueue extends Component
{
    use WithPagination;

    public string $filter = 'review'; // review | all_pending | failed

    public function approve(int $userId): void
    {
        $user = User::findOrFail($userId);
        $user->update([
            'id_verified'            => true,
            'id_verified_at'         => now(),
            'id_verification_status' => 'passed',
            'status'                 => 'active',
            'onboarding_step'        => max($user->onboarding_step, 5),
        ]);

        VerificationLog::create([
            'user_id' => $user->id,
            'event'   => 'id_check_passed',
            'detail'  => ['actioned_by' => auth()->id(), 'method' => 'manual_admin'],
        ]);

        $user->notify(new AccountVerified());
        $this->resetPage();
    }

    public function reject(int $userId): void
    {
        $user = User::findOrFail($userId);
        $user->update(['id_verification_status' => 'failed']);

        VerificationLog::create([
            'user_id' => $user->id,
            'event'   => 'id_check_failed',
            'detail'  => ['actioned_by' => auth()->id(), 'method' => 'manual_admin'],
        ]);

        $this->resetPage();
    }

    public function render()
    {
        $query = User::query();

        $query = match ($this->filter) {
            'review'       => $query->where('id_verification_status', 'review'),
            'all_pending'  => $query->where('status', 'pending'),
            'failed'       => $query->where('id_verification_status', 'failed'),
            default        => $query->where('id_verification_status', 'review'),
        };

        $users = $query->latest()->paginate(20);

        return view('livewire.admin.verification-queue', compact('users'));
    }
}
