<?php

namespace App\Livewire;

use App\Models\Lyric;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class DuplicateLyrics extends Component
{
    public ?string $message = null;

    public function delete(int $lyricId): void
    {
        Lyric::findOrFail($lyricId)->delete();
        $this->message = 'Lyric deleted.';
    }

    public function render()
    {
        // Find titles that appear more than once (case-insensitive)
        $duplicateTitles = Lyric::select(DB::raw('LOWER(title) as lower_title'))
            ->groupBy(DB::raw('LOWER(title)'))
            ->havingRaw('COUNT(*) > 1')
            ->pluck('lower_title');

        // Load all lyrics matching those titles, grouped
        $groups = [];
        foreach ($duplicateTitles as $lowerTitle) {
            $groups[] = Lyric::with('user')
                ->whereRaw('LOWER(title) = ?', [$lowerTitle])
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('livewire.duplicate-lyrics', [
            'groups' => $groups,
        ]);
    }
}
