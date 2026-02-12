<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Lyric;

class CreateLyric extends Component
{
    public $title = '';
    public $genre = '';
    public $mood = '';
    public $theme = '';
    public $pov = '';
    public $language = '';
    public $price = '';
    public $content = '';

    protected $rules = [
        'title' => 'required|string|max:255',
        'genre' => 'required|string',
        'mood' => 'nullable|string',
        'theme' => 'nullable|string',
        'pov' => 'nullable|string',
        'language' => 'nullable|string',
        'price' => 'required|numeric',
        'content' => 'required|string',
    ];

    public function submit()
    {
        $this->validate();

        $lyric = auth()->user()->lyrics()->create([
            'title' => $this->title,
            'genre' => $this->genre,
            'content' => $this->content,
            'price' => $this->price,
            'mood' => $this->mood,
            'theme' => $this->theme,
            'pov' => $this->pov,
            'language' => $this->language,
            'status' => 'published',
        ]);

        $this->reset();

        // Flash success message
        session()->flash('success', 'Lyric uploaded successfully!');
        
        // Set a session flag for redirect
        // session()->flash('redirect_after', true);

        return redirect()->to("/lyrics/{$lyric->id}/promote");
    }

    public function render()
    {
        return view('livewire.create-lyric', [
            'lyrics' => Lyric::latest()->get(),
        ]);
    }
}
