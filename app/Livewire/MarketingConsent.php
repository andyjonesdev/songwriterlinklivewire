<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class MarketingConsent extends Component
{
    public bool $allowMarketing = true;

    public function mount()
    {
        $this->allowMarketing = (bool) Auth::user()->allow_marketing;
    }

    public function updatedAllowMarketing()
    {
        Auth::user()->update([
            'allow_marketing' => $this->allowMarketing,
        ]);
    }

    public function render()
    {
        return view('livewire.marketing-consent');
    }
}
