<?php

namespace App\Livewire;

use App\Models\Lyric;
use App\Services\AiLyricChecker;
use Livewire\Component;

class AiLyricCheck extends Component
{
    public ?string $message = null;
    public ?string $error = null;

    public function runCheck(): void
    {
        set_time_limit(0);

        $this->error = null;
        $this->message = null;

        $lyrics = Lyric::whereNull('ai_flagged')->latest()->limit(10)->get();

        if ($lyrics->isEmpty()) {
            $this->message = 'All lyrics have already been checked.';
            return;
        }

        $checker = new AiLyricChecker();
        $flagged = 0;
        $checked = 0;

        foreach ($lyrics as $lyric) {
            try {
                $checker->check($lyric);
                $lyric->refresh();
                if ($lyric->ai_flagged) {
                    $flagged++;
                }
                $checked++;
            } catch (\RuntimeException $e) {
                $this->error = "Stopped at lyric #{$lyric->id} \"{$lyric->title}\": " . $e->getMessage();
                break;
            }
        }

        if ($checked > 0) {
            $this->message = "Checked {$checked} lyric(s). {$flagged} flagged as suspected AI.";
        }
    }

    public function approve(int $lyricId): void
    {
        Lyric::findOrFail($lyricId)->update(['ai_approved' => true]);
    }

    public function render()
    {
        return view('livewire.ai-lyric-check', [
            'total'     => Lyric::count(),
            'unchecked' => Lyric::whereNull('ai_flagged')->count(),
            'flagged'   => Lyric::where('ai_flagged', true)->count(),
            'lyrics'    => Lyric::with('user')->where('ai_flagged', true)->latest()->get(),
        ]);
    }
}
