<x-layouts.app :title="__('Dashboard')">
    @php
        $user    = auth()->user();
        $profile = $user->profile;

        $unreadCount = $user->conversations()
            ->with(['latestMessage'])
            ->get()
            ->filter(function ($c) use ($user) {
                $latest = $c->latestMessage;
                if (! $latest || $latest->sender_id === $user->id) return false;
                $lastRead = $c->participants->firstWhere('id', $user->id)?->pivot->last_read_at;
                return $lastRead === null || $latest->created_at->gt(\Carbon\Carbon::parse($lastRead));
            })
            ->count();

        $pendingConnections = \App\Models\Connection::where('recipient_id', $user->id)
            ->where('status', 'pending')
            ->count();

        $portfolioCount = $user->portfolioItems()->count();
    @endphp

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-zinc-900">
            Welcome back, {{ $user->name }}
        </h1>
        <p class="mt-1 text-sm text-zinc-500">
            Member since {{ $user->created_at->format('F Y') }}
        </p>
    </div>

    {{-- Onboarding incomplete notice --}}
    @if($user->status === 'pending')
        <div class="mb-6 rounded-xl border border-yellow-200 bg-yellow-50 p-4 dark:border-yellow-800 dark:bg-yellow-900/20">
            <p class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                Your account verification is not yet complete.
                <a href="{{ route('onboarding.step', $user->onboarding_step) }}" class="ml-1 underline">
                    Continue setup →
                </a>
            </p>
        </div>
    @endif

    {{-- Quick stats --}}
    <div class="mb-6 grid grid-cols-2 gap-3 sm:grid-cols-4">
        <div class="rounded-xl border border-zinc-200 bg-white p-4 text-center">
            <div class="text-2xl font-bold text-zinc-900">{{ number_format($profile?->connections_count ?? 0) }}</div>
            <div class="mt-0.5 text-xs text-zinc-500">Connections</div>
        </div>
        <div class="rounded-xl border {{ $unreadCount ? 'border-violet-200 bg-violet-50' : 'border-zinc-200 bg-white' }} p-4 text-center">
            <div class="text-2xl font-bold {{ $unreadCount ? 'text-violet-700' : 'text-zinc-900' }}">{{ $unreadCount }}</div>
            <div class="mt-0.5 text-xs {{ $unreadCount ? 'text-violet-600' : 'text-zinc-500' }}">Unread messages</div>
        </div>
        <div class="rounded-xl border {{ $pendingConnections ? 'border-green-200 bg-green-50' : 'border-zinc-200 bg-white' }} p-4 text-center">
            <div class="text-2xl font-bold {{ $pendingConnections ? 'text-green-700' : 'text-zinc-900' }}">{{ $pendingConnections }}</div>
            <div class="mt-0.5 text-xs {{ $pendingConnections ? 'text-green-600' : 'text-zinc-500' }}">Pending requests</div>
        </div>
        <div class="rounded-xl border border-zinc-200 bg-white p-4 text-center">
            <div class="text-2xl font-bold text-zinc-900">{{ $portfolioCount }}</div>
            <div class="mt-0.5 text-xs text-zinc-500">Portfolio items</div>
        </div>
    </div>

    {{-- Cards --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">

        {{-- Messages --}}
        <a href="{{ route('messages.index') }}" wire:navigate
           class="group relative rounded-xl border border-zinc-200 bg-white p-5 hover:border-brand/50 transition-colors">
            @if($unreadCount)
                <span class="absolute right-3 top-3 flex h-5 min-w-5 items-center justify-center rounded-full bg-violet-600 px-1 text-[10px] font-bold text-white">
                    {{ $unreadCount }}
                </span>
            @endif
            <div class="mb-3 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-brand/10 text-brand">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                </div>
                <h3 class="font-semibold text-zinc-900">Messages</h3>
            </div>
            <p class="text-sm text-zinc-500">{{ $unreadCount ? "{$unreadCount} unread" : 'Your conversations' }}</p>
        </a>

        {{-- Members --}}
        <a href="{{ route('members.index') }}" wire:navigate
           class="group rounded-xl border border-zinc-200 bg-white p-5 hover:border-brand/50 transition-colors">
            <div class="mb-3 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-brand/10 text-brand">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <h3 class="font-semibold text-zinc-900">Members</h3>
            </div>
            <p class="text-sm text-zinc-500">Browse &amp; connect with verified members</p>
        </a>

        {{-- Portfolio --}}
        <a href="{{ route('portfolio.index') }}" wire:navigate
           class="group rounded-xl border border-zinc-200 bg-white p-5 hover:border-brand/50 transition-colors">
            <div class="mb-3 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-brand/10 text-brand">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                </div>
                <h3 class="font-semibold text-zinc-900">Portfolio</h3>
            </div>
            <p class="text-sm text-zinc-500">{{ $portfolioCount }} item{{ $portfolioCount !== 1 ? 's' : '' }} uploaded</p>
        </a>

        {{-- My Profile --}}
        @if($profile)
            <a href="{{ route('profile.show', $profile) }}" wire:navigate
               class="group rounded-xl border border-zinc-200 bg-white p-5 hover:border-brand/50 transition-colors">
                <div class="mb-3 flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-brand/10 text-brand">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <h3 class="font-semibold text-zinc-900">My Profile</h3>
                </div>
                <p class="text-sm text-zinc-500">{{ number_format($profile->views_count) }} view{{ $profile->views_count !== 1 ? 's' : '' }} &middot; {{ number_format($profile->connections_count) }} connection{{ $profile->connections_count !== 1 ? 's' : '' }}</p>
            </a>
        @endif

        {{-- Brief Board --}}
        <a href="{{ route('briefs.index') }}" wire:navigate
           class="group rounded-xl border border-zinc-200 bg-white p-5 hover:border-brand/50 transition-colors">
            <div class="mb-3 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-brand/10 text-brand">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <h3 class="font-semibold text-zinc-900">Brief Board</h3>
            </div>
            <p class="text-sm text-zinc-500">Collaboration briefs — coming soon</p>
        </a>
    </div>
</x-layouts.app>
