<?php

namespace App\Livewire\Admin;

use App\Models\PromotedProfile;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app', ['title' => 'Admin — Promotions'])]
class Promotions extends Component
{
    use WithPagination;

    public string $addEmail   = '';
    public int    $addDays    = 30;
    public string $addError   = '';

    public function addPromotion(): void
    {
        $this->addError = '';

        $user = User::where('email', trim($this->addEmail))->first();

        if (! $user) {
            $this->addError = 'No member found with that email address.';
            return;
        }

        PromotedProfile::create([
            'user_id'   => $user->id,
            'starts_at' => now(),
            'ends_at'   => now()->addDays($this->addDays),
            'active'    => true,
        ]);

        $this->addEmail = '';
        $this->addDays  = 30;
        $this->resetPage();
    }

    public function deactivate(int $id): void
    {
        PromotedProfile::findOrFail($id)->update(['active' => false, 'ends_at' => now()]);
    }

    public function render()
    {
        $promotions = PromotedProfile::with('user.profile')
            ->latest()
            ->paginate(20);

        return view('livewire.admin.promotions', compact('promotions'));
    }
}
