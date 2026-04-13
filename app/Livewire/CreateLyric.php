<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Lyric;
use App\Services\AiLyricChecker;
use App\Services\CopyscapeChecker;
use Illuminate\Support\Facades\Log;

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
    public $originalConfirmed = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'genre' => 'required|string',
        'mood' => 'nullable|string',
        'theme' => 'nullable|string',
        'pov' => 'nullable|string',
        'language' => 'required|string',
        'price' => 'required|numeric',
        'content' => 'required|string',
        'originalConfirmed' => 'accepted',
    ];

    protected $messages = [
        'originalConfirmed.accepted' => 'You must confirm that these are your own original lyrics.',
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

        try {
            (new AiLyricChecker())->check($lyric);
            $lyric->refresh();
            if ($lyric->ai_flagged) {
                session()->flash('ai_warning', true);
            }
        } catch (\RuntimeException $e) {
            Log::warning("AI check skipped for lyric #{$lyric->id}: " . $e->getMessage());
        }

        try {
            (new CopyscapeChecker())->check($lyric);
            $lyric->refresh();
        } catch (\RuntimeException $e) {
            Log::warning("Plagiarism check skipped for lyric #{$lyric->id}: " . $e->getMessage());
        }

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
