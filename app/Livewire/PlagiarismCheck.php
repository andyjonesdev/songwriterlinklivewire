<?php

namespace App\Livewire;

use App\Models\Lyric;
use App\Services\CopyscapeChecker;
use Livewire\Component;

class PlagiarismCheck extends Component
{
    public ?string $message = null;
    public ?string $error = null;

    public function runCheck(): void
    {
        set_time_limit(0);

        $this->error = null;
        $this->message = null;

        $lyrics = Lyric::whereNull('plagiarism_flagged')->latest()->limit(10)->get();

        if ($lyrics->isEmpty()) {
            $this->message = 'All lyrics have already been checked.';
            return;
        }

        $checker = new CopyscapeChecker();
        $flagged = 0;
        $checked = 0;

        foreach ($lyrics as $lyric) {
            try {
                $checker->check($lyric);
                $lyric->refresh();
                if ($lyric->plagiarism_flagged) {
                    $flagged++;
                }
                $checked++;
            } catch (\RuntimeException $e) {
                $this->error = "Stopped at lyric #{$lyric->id} \"{$lyric->title}\": " . $e->getMessage();
                break;
            }
        }

        if ($checked > 0) {
            $this->message = "Checked {$checked} lyric(s). {$flagged} flagged as potential plagiarism.";
        }
    }

    public function delete(int $lyricId): void
    {
        Lyric::findOrFail($lyricId)->delete();
    }

    public function render()
    {
        return view('livewire.plagiarism-check', [
            'total'     => Lyric::count(),
            'unchecked' => Lyric::whereNull('plagiarism_flagged')->count(),
            'flagged'   => Lyric::where('plagiarism_flagged', true)->count(),
            'lyrics'    => Lyric::with('user')->where('plagiarism_flagged', true)->latest()->get(),
        ]);
    }
}
