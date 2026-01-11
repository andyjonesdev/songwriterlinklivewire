<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Lyric;

class SaveLyricButton extends Component
{
    public Lyric $lyric;
    public bool $isSaved;

    public function mount(Lyric $lyric)
    {
        $this->lyric = $lyric;
        $this->isSaved = $lyric->savedByUsers()
            ->where('user_id', auth()->id())
            ->exists();
    }

    public function toggleSave()
    {
        $user = auth()->user();

        if ($this->isSaved) {
            $user->savedLyrics()->detach($this->lyric->id);
            $this->isSaved = false;
        } else {
            $user->savedLyrics()->syncWithoutDetaching($this->lyric->id);
            $this->isSaved = true;
        }
    }

    public function render()
    {
        return view('livewire.save-lyric-button');
    }
}

