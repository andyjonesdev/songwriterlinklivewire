<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LyricPromote;
use Carbon\Carbon;

class PromotedLyricStats extends Component
{
    use WithPagination;

    public function render()
    {
        $now = Carbon::now();

        $totalCount    = LyricPromote::count();
        $activeCount   = LyricPromote::where('ends_at', '>=', $now)->count();
        $expiredCount  = LyricPromote::where('ends_at', '<', $now)->count();
        $totalRevenue  = LyricPromote::sum('amount');
        $manualCount   = LyricPromote::where('stripe_session_id', 'like', 'manual_%')->count();

        $promotions = LyricPromote::with(['lyric', 'user'])
            ->orderByDesc('starts_at')
            ->paginate(20);

        return view('livewire.promoted-lyric-stats', compact(
            'totalCount',
            'activeCount',
            'expiredCount',
            'totalRevenue',
            'manualCount',
            'promotions',
        ));
    }
}
