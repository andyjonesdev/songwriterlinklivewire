<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Lyric;
class PromoteLyric extends Component
{
    public Lyric $lyric;
    public $bid = 5;
    public $duration = 1;
    public $placement = '';

    protected $rules = [
        'placement' => 'required|string',
        'bid' => 'required|numeric',
        'duration' => 'required|numeric',
    ];

    // Computed property
    public function getEstimatedCostProperty()
    {
        $placement_cost = 1;
        if ($this->placement=='all') {
            $placement_cost = 2;
        }
        return $this->bid * ($this->duration) * $placement_cost;
    }

    // Redirect to Stripe on submit
    public function pay()
    {
        $this->validate();

        if ($this->getEstimatedCostProperty()=='5') {
            $stripeUrl = "https://buy.stripe.com/3cI6oA3Jc7LI4UzgiWbo406";
        }
        if ($this->getEstimatedCostProperty()=='10') {
            $stripeUrl = "https://buy.stripe.com/cNiaEQgvYgiedr56Imbo407";
        }
        if ($this->getEstimatedCostProperty()=='20') {
            $stripeUrl = "https://buy.stripe.com/8x200c6Vofea9aP4Aebo401";
        }
        if ($this->getEstimatedCostProperty()=='40') {
            $stripeUrl = "https://buy.stripe.com/dRm6oA5Rkd62cn11o2bo408";
        }
        if ($this->getEstimatedCostProperty()=='80') {
            $stripeUrl = "https://buy.stripe.com/dRm9AM5Rkc1YgDh9Uybo409";
        }
        
        $stripeUrlWithParams = $stripeUrl . "?prefilled_email="
                     . auth()->user()->email
                     . "&client_reference_id=pro-" . auth()->id() . "-" . $this->lyric->id
                     . "-" . $this->bid
                     . "-" . $this->placement
                     . "-" . $this->duration;

        return redirect()->to($stripeUrlWithParams);
    }

    public function render()
    {
        return view('livewire.promote-lyric');
    }
}
