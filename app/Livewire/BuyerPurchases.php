<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\LyricPurchase;
class BuyerPurchases extends Component
{
    public $purchases;

    public function mount()
    {
        $this->purchases = LyricPurchase::with([
                    'user',               // buyer
                    'lyric.writer'        // lyric + writer
                ])
                ->where('user_id', auth()->id())
                ->get();
    }

    public function render()
    {
        return view('livewire.buyer-purchases');
    }
}