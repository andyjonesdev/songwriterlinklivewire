<?php

namespace App\Livewire\Settings;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Subscription'])]
class Subscription extends Component
{
    public function render()
    {
        $user = auth()->user();

        return view('livewire.settings.subscription', compact('user'));
    }
}
