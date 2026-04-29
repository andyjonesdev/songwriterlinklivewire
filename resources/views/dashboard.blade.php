<x-layouts.app :title="__('Dashboard')">
    @php
        $user    = auth()->user();
        $profile = $user->profile;
        $userId  = $user->id;

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

        $pendingConnections = \App\Models\Connection::where('recipient_id', $userId)
            ->where('status', 'pending')
            ->count();

        $portfolioCount = $user->portfolioItems()->count();

        $openBriefCount = \App\Models\Brief::where('status', 'open')
            ->where(fn ($q) => $q->whereNull('expires_at')->orWhere('expires_at', '>', now()))
            ->count();

        $myBriefCount = $user->isPro()
            ? $user->briefs()->where('status', 'open')
                ->where(fn ($q) => $q->whereNull('expires_at')->orWhere('expires_at', '>', now()))
                ->count()
            : 0;

        // Suggested connections — same role or genre overlap, not yet connected
        $connectedIds = \App\Models\Connection::where('requester_id', $userId)
            ->orWhere('recipient_id', $userId)
            ->get()
            ->flatMap(fn ($c) => [$c->requester_id, $c->recipient_id])
            ->push($userId)
            ->unique()
            ->values()
            ->all();

        $myGenres  = $profile?->genres ?? [];
        $myRole    = $user->role;

        $candidates = \App\Models\Profile::with('user')
            ->whereNotIn('user_id', $connectedIds)
            ->whereHas('user', fn ($q) =>
                $q->where('status', 'active')->where('id_verified', true)
            )
            ->get()
            ->filter(function ($p) use ($myRole, $myGenres) {
                if ($p->user->role === $myRole) return true;
                if ($myGenres && array_intersect($myGenres, $p->genres ?? [])) return true;
                return false;
            })
            ->shuffle()
            ->take(4);

        // If fewer than 4 genre/role matches, pad with any active verified members
        if ($candidates->count() < 4) {
            $padIds = $candidates->pluck('user_id')->merge($connectedIds)->all();
            $pad = \App\Models\Profile::with('user')
                ->whereNotIn('user_id', $padIds)
                ->whereHas('user', fn ($q) => $q->where('status', 'active')->where('id_verified', true))
                ->inRandomOrder()
                ->limit(4 - $candidates->count())
                ->get();
            $candidates = $candidates->merge($pad);
        }

        // Activity feed
        $recentMembers = \App\Models\Profile::with('user')
            ->whereHas('user', fn ($q) =>
                $q->where('status', 'active')->where('id_verified', true)
                  ->where('created_at', '>=', now()->subDays(7))
            )
            ->latest()
            ->limit(5)
            ->get();

        $recentBriefs = \App\Models\Brief::where('status', 'open')
            ->where(fn ($q) => $q->whereNull('expires_at')->orWhere('expires_at', '>', now()))
            ->where('created_at', '>=', now()->subDays(7))
            ->latest()
            ->limit(5)
            ->get();
    @endphp

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-zinc-900">Welcome back, {{ $user->name }}</h1>
        <p class="mt-1 text-sm text-zinc-500">Member since {{ $user->created_at->format('F Y') }}</p>
    </div>

    {{-- Onboarding incomplete notice --}}
    @if($user->status === 'pending')
        <div class="mb-6 rounded-xl border border-yellow-200 bg-yellow-50 p-4">
            <p class="text-sm font-medium text-yellow-800">
                Your account verification is not yet complete.
                <a href="{{ route('onboarding.step', $user->onboarding_step) }}" class="ml-1 underline">Continue setup →</a>
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

    {{-- Quick link cards --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">

        <a href="{{ route('messages.index') }}" wire:navigate
           class="group relative rounded-xl border border-zinc-200 bg-white p-5 hover:border-brand/50 transition-colors">
            @if($unreadCount)
                <span class="absolute right-3 top-3 flex h-5 min-w-5 items-center justify-center rounded-full bg-violet-600 px-1 text-[10px] font-bold text-white">{{ $unreadCount }}</span>
            @endif
            <div class="mb-3 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-brand/10 text-brand">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                </div>
                <h3 class="font-semibold text-zinc-900">Messages</h3>
            </div>
            <p class="text-sm text-zinc-500">{{ $unreadCount ? "{$unreadCount} unread" : 'Your conversations' }}</p>
        </a>

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

        <a href="{{ route('briefs.index') }}" wire:navigate
           class="group rounded-xl border border-zinc-200 bg-white p-5 hover:border-brand/50 transition-colors">
            <div class="mb-3 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-brand/10 text-brand">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <h3 class="font-semibold text-zinc-900">Brief Board</h3>
            </div>
            <p class="text-sm text-zinc-500">{{ $openBriefCount }} open {{ Str::plural('brief', $openBriefCount) }} — browse &amp; apply</p>
        </a>

        @if($user->isPro())
            <a href="{{ route('briefs.mine') }}" wire:navigate
               class="group rounded-xl border border-zinc-200 bg-white p-5 hover:border-brand/50 transition-colors">
                <div class="mb-3 flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-brand/10 text-brand">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </div>
                    <h3 class="font-semibold text-zinc-900">My Briefs</h3>
                </div>
                <p class="text-sm text-zinc-500">
                    {{ $myBriefCount }} open {{ Str::plural('brief', $myBriefCount) }}
                    @if(!$user->isProPlus()) · <span class="text-zinc-400">3 max</span> @endif
                </p>
            </a>
        @endif

        {{-- Pro+ tools --}}
        @if($user->isProPlus())
            <a href="{{ route('credits.index') }}" wire:navigate
               class="group rounded-xl border border-violet-200 bg-violet-50 p-5 hover:border-violet-300 transition-colors">
                <div class="mb-3 flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-violet-100 text-violet-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h3 class="font-semibold text-zinc-900">Credits / CV Export</h3>
                </div>
                <p class="text-sm text-zinc-500">Download your professional credits as a PDF</p>
            </a>

            <a href="{{ route('split-sheet.index') }}" wire:navigate
               class="group rounded-xl border border-violet-200 bg-violet-50 p-5 hover:border-violet-300 transition-colors">
                <div class="mb-3 flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-violet-100 text-violet-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <h3 class="font-semibold text-zinc-900">Split Sheet Generator</h3>
                </div>
                <p class="text-sm text-zinc-500">Create &amp; download collaboration split sheets</p>
            </a>
        @endif
    </div>

    {{-- Suggested connections --}}
    @if($candidates->count())
        <div class="mt-8 space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-zinc-900">Suggested connections</h2>
                <a href="{{ route('members.index') }}" wire:navigate class="text-sm text-violet-600 hover:underline">Browse all →</a>
            </div>
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($candidates as $candidate)
                    <a href="{{ route('profile.show', $candidate) }}" wire:navigate
                       class="flex items-center gap-3 rounded-xl border border-zinc-200 bg-white p-4 hover:border-violet-300 hover:shadow-sm transition-all">
                        @if($candidate->profile_photo_path)
                            <img src="{{ Storage::url($candidate->profile_photo_path) }}"
                                 class="h-10 w-10 shrink-0 rounded-full object-cover" alt="" />
                        @else
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-violet-100 text-sm font-bold text-violet-700">
                                {{ strtoupper(substr($candidate->display_name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="min-w-0">
                            <p class="truncate text-sm font-medium text-zinc-900">{{ $candidate->display_name }}</p>
                            <p class="truncate text-xs text-zinc-400 capitalize">{{ $candidate->user->role }}</p>
                            @if($candidate->genres)
                                <p class="truncate text-xs text-zinc-400">{{ collect($candidate->genres)->take(2)->implode(', ') }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Activity feed --}}
    @if($recentMembers->count() || $recentBriefs->count())
        <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">

            @if($recentMembers->count())
                <div class="space-y-3">
                    <h2 class="text-lg font-semibold text-zinc-900">New this week</h2>
                    <div class="rounded-xl border border-zinc-200 bg-white divide-y divide-zinc-100">
                        @foreach($recentMembers as $member)
                            <a href="{{ route('profile.show', $member) }}" wire:navigate
                               class="flex items-center gap-3 px-4 py-3 hover:bg-zinc-50 transition-colors">
                                @if($member->profile_photo_path)
                                    <img src="{{ Storage::url($member->profile_photo_path) }}"
                                         class="h-8 w-8 shrink-0 rounded-full object-cover" alt="" />
                                @else
                                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-violet-100 text-xs font-bold text-violet-700">
                                        {{ strtoupper(substr($member->display_name, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-medium text-zinc-900">{{ $member->display_name }}</p>
                                    <p class="text-xs text-zinc-400 capitalize">{{ $member->user->role }}</p>
                                </div>
                                @if($member->user->id_verified)
                                    <svg class="h-4 w-4 shrink-0 text-violet-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($recentBriefs->count())
                <div class="space-y-3">
                    <h2 class="text-lg font-semibold text-zinc-900">New briefs this week</h2>
                    <div class="rounded-xl border border-zinc-200 bg-white divide-y divide-zinc-100">
                        @foreach($recentBriefs as $brief)
                            <a href="{{ route('briefs.show', $brief) }}" wire:navigate
                               class="block px-4 py-3 hover:bg-zinc-50 transition-colors">
                                <p class="truncate text-sm font-medium text-zinc-900">{{ $brief->title }}</p>
                                <p class="text-xs text-zinc-400">{{ $brief->created_at->diffForHumans() }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    @endif

</x-layouts.app>
