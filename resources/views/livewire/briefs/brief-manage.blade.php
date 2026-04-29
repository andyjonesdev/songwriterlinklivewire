@php
    $categoryColors = [
        'co_writer'        => 'bg-violet-100 text-violet-700',
        'topline'          => 'bg-sky-100 text-sky-700',
        'sync_placement'   => 'bg-amber-100 text-amber-700',
        'ghost_write'      => 'bg-zinc-100 text-zinc-700',
        'session_lyricist' => 'bg-green-100 text-green-700',
    ];
@endphp

<div class="mx-auto max-w-3xl space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900">My Briefs</h1>
            <p class="mt-0.5 text-sm text-zinc-500">Manage your posted briefs and review applications.</p>
        </div>
        @if(auth()->user()->isPro())
            <a href="{{ route('briefs.create') }}" wire:navigate
               class="flex items-center gap-1.5 rounded-lg bg-violet-600 px-4 py-2 text-sm font-semibold text-white hover:bg-violet-700 transition">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Post a Brief
            </a>
        @endif
    </div>

    @if(session('status'))
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('status') }}</div>
    @endif

    @if($briefs->isEmpty())
        <div class="flex flex-col items-center gap-3 rounded-xl border border-zinc-100 bg-zinc-50 py-16 text-center">
            <svg class="h-10 w-10 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            <p class="text-sm font-medium text-zinc-500">You haven't posted any briefs yet.</p>
            @if(auth()->user()->isPro())
                <a href="{{ route('briefs.create') }}" wire:navigate
                   class="text-sm font-medium text-violet-600 hover:underline">Post your first brief</a>
            @else
                <a href="{{ route('onboarding.step', 8) }}" wire:navigate
                   class="text-sm font-medium text-violet-600 hover:underline">Upgrade to Pro to post briefs</a>
            @endif
        </div>
    @else
        <div class="space-y-4">
            @foreach($briefs as $brief)
                <div class="rounded-xl border border-zinc-200 bg-white p-5 space-y-4">

                    {{-- Header row --}}
                    <div class="flex items-start justify-between gap-4">
                        <div class="space-y-1.5 flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="rounded-full px-2.5 py-0.5 text-xs font-medium {{ $categoryColors[$brief->category] ?? 'bg-zinc-100 text-zinc-700' }}">
                                    {{ $categories[$brief->category] ?? $brief->category }}
                                </span>
                                @if($brief->status === 'open' && (!$brief->expires_at || !$brief->expires_at->isPast()))
                                    <span class="rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-700">Open</span>
                                @elseif($brief->status === 'closed')
                                    <span class="rounded-full bg-zinc-100 px-2.5 py-0.5 text-xs font-medium text-zinc-500">Closed</span>
                                @else
                                    <span class="rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-600">Expired</span>
                                @endif
                            </div>
                            <h3 class="font-semibold text-zinc-900">{{ $brief->title }}</h3>
                            <p class="text-xs text-zinc-400">
                                Posted {{ $brief->created_at->diffForHumans() }}
                                @if($brief->expires_at && !$brief->expires_at->isPast())
                                    · Expires {{ $brief->expires_at->format('d M Y') }}
                                @endif
                                @if($brief->deadline)
                                    · Deadline {{ $brief->deadline->format('d M Y') }}
                                @endif
                            </p>
                        </div>

                        {{-- Controls --}}
                        <div class="flex shrink-0 items-center gap-2">
                            @if($brief->status === 'open' && (!$brief->expires_at || !$brief->expires_at->isPast()))
                                <button wire:click="closeBrief({{ $brief->id }})"
                                        class="rounded-lg border border-zinc-200 px-3 py-1.5 text-xs font-medium text-zinc-600 hover:border-zinc-300 transition">
                                    Close
                                </button>
                            @else
                                <button wire:click="reopenBrief({{ $brief->id }})"
                                        class="rounded-lg border border-violet-200 bg-violet-50 px-3 py-1.5 text-xs font-medium text-violet-700 hover:bg-violet-100 transition">
                                    Reopen
                                </button>
                            @endif
                            <a href="{{ route('briefs.show', $brief) }}" wire:navigate
                               class="rounded-lg border border-zinc-200 px-3 py-1.5 text-xs font-medium text-zinc-600 hover:border-zinc-300 transition">
                                View
                            </a>
                        </div>
                    </div>

                    {{-- Stats row --}}
                    <div class="flex items-center gap-4 border-t border-zinc-100 pt-3">
                        <div class="flex items-center gap-1.5 text-sm">
                            <svg class="h-4 w-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span class="font-medium text-zinc-700">{{ $brief->applications_count }}</span>
                            <span class="text-zinc-400">{{ Str::plural('application', $brief->applications_count) }}</span>
                        </div>
                        @php
                            $shortlisted = $brief->applications_count > 0
                                ? $brief->applications->where('status', 'shortlisted')->count()
                                : 0;
                        @endphp
                        @if($shortlisted > 0)
                            <div class="flex items-center gap-1.5 text-sm text-green-600">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                {{ $shortlisted }} shortlisted
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
