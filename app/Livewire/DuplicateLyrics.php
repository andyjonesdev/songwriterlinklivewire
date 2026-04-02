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
        // Find groups where both title AND content are identical
        $duplicates = Lyric::select(DB::raw('LOWER(title) as lower_title, MD5(LOWER(TRIM(content))) as content_hash'))
            ->groupBy(DB::raw('LOWER(title), MD5(LOWER(TRIM(content)))'))
            ->havingRaw('COUNT(*) > 1')
            ->get();

        $groups = [];
        foreach ($duplicates as $row) {
            $groups[] = Lyric::with('user')
                ->whereRaw('LOWER(title) = ?', [$row->lower_title])
                ->whereRaw('MD5(LOWER(TRIM(content))) = ?', [$row->content_hash])
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('livewire.duplicate-lyrics', [
            'groups' => $groups,
        ]);
    }
}
