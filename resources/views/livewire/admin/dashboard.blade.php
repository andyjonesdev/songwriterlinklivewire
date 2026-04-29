<div class="mx-auto max-w-5xl space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-zinc-900">Admin Dashboard</h1>
        <p class="mt-0.5 text-sm text-zinc-500">Platform overview and health metrics.</p>
    </div>

    @include('partials.admin-nav')

    {{-- Alerts row --}}
    @if($stats['open_reports'] || $stats['pending_id_review'] || $stats['pending_producer_badge'])
        <div class="flex flex-wrap gap-3">
            @if($stats['open_reports'])
                <a href="{{ route('admin.reports') }}" wire:navigate
                   class="flex items-center gap-2 rounded-lg border border-red-200 bg-red-50 px-4 py-2.5 text-sm font-medium text-red-700 hover:bg-red-100 transition">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    {{ $stats['open_reports'] }} open {{ Str::plural('report', $stats['open_reports']) }}
                </a>
            @endif
            @if($stats['pending_id_review'])
                <a href="{{ route('admin.verification-queue') }}" wire:navigate
                   class="flex items-center gap-2 rounded-lg border border-amber-200 bg-amber-50 px-4 py-2.5 text-sm font-medium text-amber-700 hover:bg-amber-100 transition">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    {{ $stats['pending_id_review'] }} pending verification
                </a>
            @endif
            @if($stats['pending_producer_badge'])
                <a href="{{ route('admin.producer-badges') }}" wire:navigate
                   class="flex items-center gap-2 rounded-lg border border-violet-200 bg-violet-50 px-4 py-2.5 text-sm font-medium text-violet-700 hover:bg-violet-100 transition">
                    {{ $stats['pending_producer_badge'] }} badge {{ Str::plural('request', $stats['pending_producer_badge']) }}
                </a>
            @endif
        </div>
    @endif

    {{-- Member stats --}}
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <div class="rounded-xl border border-zinc-200 bg-white p-4 text-center">
            <div class="text-2xl font-bold text-zinc-900">{{ number_format($stats['total_members']) }}</div>
            <div class="mt-0.5 text-xs text-zinc-500">Total members</div>
        </div>
        <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-center">
            <div class="text-2xl font-bold text-green-700">{{ number_format($stats['active_members']) }}</div>
            <div class="mt-0.5 text-xs text-green-600">Active</div>
        </div>
        <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 text-center">
            <div class="text-2xl font-bold text-amber-700">{{ number_format($stats['pending_verification']) }}</div>
            <div class="mt-0.5 text-xs text-amber-600">Pending</div>
        </div>
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-center">
            <div class="text-2xl font-bold text-red-700">{{ number_format($stats['suspended']) }}</div>
            <div class="mt-0.5 text-xs text-red-600">Suspended</div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        {{-- Signups --}}
        <div class="rounded-xl border border-zinc-200 bg-white p-5 space-y-3">
            <h3 class="text-sm font-semibold text-zinc-700">New signups</h3>
            <div class="flex gap-6">
                <div>
                    <div class="text-2xl font-bold text-zinc-900">{{ $stats['signups_today'] }}</div>
                    <div class="text-xs text-zinc-400">Today</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-zinc-900">{{ $stats['signups_week'] }}</div>
                    <div class="text-xs text-zinc-400">Last 7 days</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-zinc-900">{{ $stats['signups_month'] }}</div>
                    <div class="text-xs text-zinc-400">Last 30 days</div>
                </div>
            </div>
        </div>

        {{-- Subscriptions --}}
        <div class="rounded-xl border border-zinc-200 bg-white p-5 space-y-3">
            <h3 class="text-sm font-semibold text-zinc-700">Subscriptions</h3>
            <div class="flex gap-6">
                <div>
                    <div class="text-2xl font-bold text-zinc-900">{{ $stats['tier_free'] }}</div>
                    <div class="text-xs text-zinc-400">Free</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-violet-700">{{ $stats['tier_pro'] }}</div>
                    <div class="text-xs text-zinc-400">Pro</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-violet-900">{{ $stats['tier_pro_plus'] }}</div>
                    <div class="text-xs text-zinc-400">Pro+</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent signups --}}
    <div class="rounded-xl border border-zinc-200 bg-white p-5">
        <h3 class="mb-4 text-sm font-semibold text-zinc-700">Recent signups</h3>
        <div class="divide-y divide-zinc-100">
            @foreach($recentSignups as $u)
                <div class="flex items-center justify-between py-2.5">
                    <div>
                        <p class="text-sm font-medium text-zinc-900">{{ $u->name }}</p>
                        <p class="text-xs text-zinc-400">{{ $u->email }} · {{ $u->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="rounded-full px-2 py-0.5 text-xs font-medium
                            {{ $u->status === 'active' ? 'bg-green-100 text-green-700' : ($u->status === 'suspended' ? 'bg-red-100 text-red-600' : 'bg-amber-100 text-amber-700') }}">
                            {{ ucfirst($u->status) }}
                        </span>
                        <span class="text-xs text-zinc-400">{{ ucfirst(str_replace('_', '+', $u->subscription_tier)) }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
