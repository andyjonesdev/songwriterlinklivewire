<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class SocialUsageConsent extends Component
{
    public bool $allowSocialUse = true;

    public function mount()
    {
        $this->allowSocialUse = (bool) Auth::user()->allow_social_use;
    }

    public function updatedAllowSocialUse()
    {
        Auth::user()->update([
            'allow_social_use' => $this->allowSocialUse,
        ]);
    }

    public function render()
    {
        return view('livewire.social-usage-consent');
    }
}
