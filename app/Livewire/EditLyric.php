<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Lyric;

class EditLyric extends Component
{
    public Lyric $lyric;
    public $title;
    public $genre;
    public $mood;
    public $theme;
    public $pov;
    public $language;
    public $price;
    public $content;

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'genre' => 'required|string',
            'mood' => 'nullable|string',
            'theme' => 'nullable|string',
            'pov' => 'nullable|string',
            'language' => 'nullable|string',
            'price' => 'required|numeric',
            'content' => 'required|string',
        ];
    }

    public function mount(Lyric $lyric)
    {
        // Ownership check (critical)
        abort_unless($lyric->user_id === auth()->id(), 403);

        $this->lyric = $lyric;

        // Prefill form
        $this->fill($lyric->only([
            'title',
            'genre',
            'mood',
            'theme',
            'pov',
            'language',
            'price',
            'content',
        ]));
    }

    public function update()
    {
        $this->validate();

        $this->lyric->update([
            'title' => $this->title,
            'genre' => $this->genre,
            'mood' => $this->mood,
            'theme' => $this->theme,
            'pov' => $this->pov,
            'language' => $this->language,
            'price' => $this->price,
            'content' => $this->content,
        ]);

        session()->flash('success', 'Lyric updated successfully!');
    }

    public function render()
    {
        return view('livewire.edit-lyric');
    }
}
