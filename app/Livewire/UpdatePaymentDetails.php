<?php

namespace App\Livewire;

use Livewire\Component;

class UpdatePaymentDetails extends Component
{
    public $paypal_email;
    public $updated = false;

    protected $rules = [
        'paypal_email' => 'required|email|max:255',
    ];

    public function mount($user_account)
    {
        $this->paypal_email = $user_account->paypal_email ?? '';
    }

    public function submit()
    {
        $this->validate();

        // Update user's PayPal email
        $user = auth()->user();
        auth()->user()->account()->update([
            'paypal_email' => $this->paypal_email,
        ]);


        $this->updated = true;

        session()->flash('success', 'Payment details updated successfully!');
    }

    public function render()
    {
        return view('livewire.update-payment-details');
    }
}
