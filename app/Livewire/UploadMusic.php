<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Music;

class UploadMusic extends Component
{
    use WithFileUploads;

    public $title;
    public $genre;
    public $audio;
    public $success = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'audio' => 'required|mimes:mp3,wav|max:20480', // 20MB
    ];

    public function save()
    {
        $this->validate();

        $path = $this->audio->store('music', 'public');

        auth()->user()->music()->create([
            'title' => $this->title,
            'file_path' => $path,
        ]);

        $this->reset(['title', 'audio']);
        $this->success = true;
    }

    public function render()
    {
        return view('livewire.upload-music');
    }
}
