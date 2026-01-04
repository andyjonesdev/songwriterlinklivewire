<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class SellerProfile extends Component
{
    public $bio;
    public $updated = false;

    protected $rules = [
        'bio' => 'required|string|max:10000',
    ];

    public function mount()
    {
        $this->bio = Auth::user()->bio ?? '';
    }

    public function updateProfile()
    {
        $this->validate();

        $user = Auth::user();
        $user->bio = $this->bio;
        $user->save();

        $this->updated = true;

        // Clear message after 3 seconds
        // $this->dispatchBrowserEvent('clear-updated-message', ['timeout' => 3000]);
        session()->flash('success', 'Bio updated successfully!');
    }

    public function render()
    {
        return view('livewire.seller-profile');
    }
}
