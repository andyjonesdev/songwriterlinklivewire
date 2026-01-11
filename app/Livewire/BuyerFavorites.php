<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\LyricPurchase;

class BuyerFavorites extends Component
{
    
    public function render()
    {
        $favorites = auth()->user()
            ->savedLyrics()
            ->with('writer')
            ->latest('saved_lyrics.created_at')
            ->paginate(6);

        return view('livewire.buyer-favorites', [
            'favorites' => $favorites,
        ]);
    }
}
