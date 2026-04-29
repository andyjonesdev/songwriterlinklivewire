<?php

namespace App\Livewire\Admin;

use App\Models\Brief;
use App\Models\Report;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Admin — Dashboard'])]
class Dashboard extends Component
{
    public function render()
    {
        $stats = [
            'total_members'        => User::count(),
            'active_members'       => User::where('status', 'active')->count(),
            'pending_verification' => User::where('status', 'pending')->count(),
            'suspended'            => User::whereIn('status', ['suspended', 'banned'])->count(),

            'tier_free'     => User::where('subscription_tier', 'free')->count(),
            'tier_pro'      => User::where('subscription_tier', 'pro')->where('subscription_expires_at', '>', now())->count(),
            'tier_pro_plus' => User::where('subscription_tier', 'pro_plus')->where('subscription_expires_at', '>', now())->count(),

            'signups_today' => User::whereDate('created_at', today())->count(),
            'signups_week'  => User::where('created_at', '>=', now()->subWeek())->count(),
            'signups_month' => User::where('created_at', '>=', now()->subMonth())->count(),

            'open_reports'           => Report::where('status', 'open')->count(),
            'pending_id_review'      => User::where('id_verification_status', 'review')->count(),
            'pending_producer_badge' => User::where('producer_badge_status', 'pending')->count(),
            'pending_publisher_badge'=> User::where('publisher_badge_status', 'pending')->count(),

            'open_briefs' => Brief::where('status', 'open')->count(),
        ];

        $recentSignups = User::latest()->limit(8)->get();

        return view('livewire.admin.dashboard', compact('stats', 'recentSignups'));
    }
}
