<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app.sidebar')]
#[Title('Analytics')]
class Analytics extends Component
{
    public string $period = '30'; // '7' | '30' | '90'

    public function render()
    {
        $user    = Auth::user();
        $profile = $user->profile;

        abort_unless($user->isProPlus(), 403);

        $days = (int) $this->period;

        // ── View sparkline data ────────────────────────────────────────────────
        $viewLogs = $profile
            ? DB::table('profile_view_logs')
                ->where('profile_id', $profile->id)
                ->where('viewed_on', '>=', now()->subDays($days - 1)->toDateString())
                ->orderBy('viewed_on')
                ->pluck('view_count', 'viewed_on')
            : collect();

        // Fill every day in range with 0 if no entry
        $viewSeries = [];
        $viewLabels = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date          = now()->subDays($i)->toDateString();
            $viewLabels[]  = now()->subDays($i)->format('d M');
            $viewSeries[]  = (int) ($viewLogs[$date] ?? 0);
        }

        $viewsThisPeriod = array_sum($viewSeries);
        $viewsPrevPeriod = $profile
            ? DB::table('profile_view_logs')
                ->where('profile_id', $profile->id)
                ->whereBetween('viewed_on', [
                    now()->subDays($days * 2 - 1)->toDateString(),
                    now()->subDays($days)->toDateString(),
                ])
                ->sum('view_count')
            : 0;

        $viewsTrend = $viewsPrevPeriod > 0
            ? round((($viewsThisPeriod - $viewsPrevPeriod) / $viewsPrevPeriod) * 100)
            : null;

        // ── Connection stats ───────────────────────────────────────────────────
        $connectionsTotal = $profile?->connections_count ?? 0;
        $connectionsPending = \App\Models\Connection::where('recipient_id', $user->id)
            ->where('status', 'pending')
            ->count();

        $connectionsThisPeriod = \App\Models\Connection::where(function ($q) use ($user) {
                $q->where('requester_id', $user->id)->orWhere('recipient_id', $user->id);
            })
            ->where('status', 'accepted')
            ->where('updated_at', '>=', now()->subDays($days))
            ->count();

        // ── Brief application stats ────────────────────────────────────────────
        $appTotal      = $user->briefApplications()->count();
        $appShortlisted = $user->briefApplications()->where('status', 'shortlisted')->count();
        $appDeclined   = $user->briefApplications()->where('status', 'declined')->count();
        $appPending    = $user->briefApplications()->where('status', 'pending')->count();

        $shortlistRate = $appTotal > 0
            ? round(($appShortlisted / $appTotal) * 100)
            : null;

        // ── Profile completeness score ─────────────────────────────────────────
        $checks = [
            'Photo'         => !empty($profile?->profile_photo_path),
            'Bio'           => !empty($profile?->bio),
            'Location'      => !empty($profile?->location),
            'Genres'        => !empty($profile?->genres),
            'Social links'  => !empty($profile?->social_links),
            'Portfolio item' => $user->portfolioItems()->exists(),
            'Credit'        => $user->credits()->exists(),
        ];
        $completenessScore = $checks
            ? (int) round((count(array_filter($checks)) / count($checks)) * 100)
            : 0;

        return view('livewire.analytics', [
            'profile'              => $profile,
            'viewLabels'           => json_encode($viewLabels),
            'viewSeries'           => json_encode($viewSeries),
            'viewsThisPeriod'      => $viewsThisPeriod,
            'viewsTrend'           => $viewsTrend,
            'viewsLifetime'        => $profile?->views_count ?? 0,
            'connectionsTotal'     => $connectionsTotal,
            'connectionsPending'   => $connectionsPending,
            'connectionsThisPeriod'=> $connectionsThisPeriod,
            'appTotal'             => $appTotal,
            'appShortlisted'       => $appShortlisted,
            'appDeclined'          => $appDeclined,
            'appPending'           => $appPending,
            'shortlistRate'        => $shortlistRate,
            'completenessScore'    => $completenessScore,
            'completenessChecks'   => $checks,
        ]);
    }
}
