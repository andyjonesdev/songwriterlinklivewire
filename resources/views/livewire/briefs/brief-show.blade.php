@php
    $categoryLabels = \App\Livewire\Briefs\BriefIndex::categories();
    $compensationLabels = \App\Livewire\Briefs\BriefIndex::compensationTypes();
    $categoryColors = [
        'co_writer'        => 'bg-violet-100 text-violet-700',
        'topline'          => 'bg-sky-100 text-sky-700',
        'sync_placement'   => 'bg-amber-100 text-amber-700',
        'ghost_write'      => 'bg-zinc-100 text-zinc-700',
        'session_lyricist' => 'bg-green-100 text-green-700',
    ];
    $poster = $brief->user;
@endphp

<div class="mx-auto max-w-3xl space-y-6">

    {{-- Back --}}
    <a href="{{ route('briefs.index') }}" wire:navigate
       class="flex items-center gap-1 text-sm text-zinc-400 hover:text-zinc-600 transition-colors">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Brief Board
    </a>

    @if(session('status'))
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('status') }}</div>
    @endif

    {{-- Brief card --}}
    <div class="rounded-xl border border-zinc-200 bg-white p-6 space-y-5">

        {{-- Header --}}
        <div class="flex items-start justify-between gap-4">
            <div class="space-y-2 flex-1 min-w-0">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="rounded-full px-2.5 py-0.5 text-xs font-medium {{ $categoryColors[$brief->category] ?? 'bg-zinc-100 text-zinc-700' }}">
                        {{ $categoryLabels[$brief->category] ?? $brief->category }}
                    </span>
                    @if($brief->status === 'closed')
                        <span class="rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-700">Closed</span>
                    @elseif($brief->expires_at && $brief->expires_at->isPast())
                        <span class="rounded-full bg-zinc-100 px-2.5 py-0.5 text-xs font-medium text-zinc-500">Expired</span>
                    @endif
                </div>
                <h1 class="text-2xl font-bold text-zinc-900">{{ $brief->title }}</h1>
            </div>

            {{-- Poster controls --}}
            @if($isOwner)
                <div class="flex shrink-0 items-center gap-2">
                    @if($brief->status === 'open' && (!$brief->expires_at || !$brief->expires_at->isPast()))
                        <button wire:click="closeBrief"
                                class="rounded-lg border border-zinc-200 px-3 py-1.5 text-xs font-medium text-zinc-600 hover:border-zinc-300 hover:text-zinc-800 transition">
                            Close brief
                        </button>
                    @else
                        <button wire:click="reopenBrief"
                                class="rounded-lg border border-violet-200 bg-violet-50 px-3 py-1.5 text-xs font-medium text-violet-700 hover:bg-violet-100 transition">
                            Reopen brief
                        </button>
                    @endif
                </div>
            @endif
        </div>

        {{-- Meta row --}}
        <div class="flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-zinc-500">
            {{-- Poster --}}
            <div class="flex items-center gap-2">
                <div class="flex h-6 w-6 items-center justify-center rounded-full bg-violet-100 text-[10px] font-bold text-violet-700">
                    {{ strtoupper(substr($poster?->profile?->display_name ?? $poster?->name ?? '?', 0, 1)) }}
                </div>
                <span>{{ $poster?->profile?->display_name ?? $poster?->name }}</span>
            </div>
            {{-- Compensation --}}
            @if($brief->compensation_type)
                <span class="flex items-center gap-1">
                    <svg class="h-4 w-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $compensationLabels[$brief->compensation_type] ?? $brief->compensation_type }}
                    @if($brief->compensation_detail)
                        — {{ $brief->compensation_detail }}
                    @endif
                </span>
            @endif
            {{-- Deadline --}}
            @if($brief->deadline)
                <span class="flex items-center gap-1">
                    <svg class="h-4 w-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Due {{ $brief->deadline->format('d M Y') }}
                </span>
            @endif
            {{-- Posted --}}
            <span class="flex items-center gap-1">
                <svg class="h-4 w-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Posted {{ $brief->created_at->diffForHumans() }}
            </span>
        </div>

        {{-- Genres --}}
        @if($brief->genres && count($brief->genres))
            <div class="flex flex-wrap gap-1.5">
                @foreach($brief->genres as $genre)
                    <span class="rounded-full border border-violet-200 bg-violet-50 px-2.5 py-0.5 text-xs font-medium text-violet-700">{{ $genre }}</span>
                @endforeach
            </div>
        @endif

        {{-- Description --}}
        <div class="prose prose-sm max-w-none text-zinc-700">
            {!! nl2br(e($brief->description)) !!}
        </div>
    </div>

    {{-- ── Apply section ─────────────────────────────────────────────────── --}}
    @if(!$isOwner)
        <div class="rounded-xl border border-zinc-200 bg-white p-6 space-y-4">
            <h2 class="text-base font-semibold text-zinc-900">Apply to this brief</h2>

            @if(!auth()->check())
                <p class="text-sm text-zinc-500">
                    <a href="{{ route('login') }}" class="font-medium text-violet-600 hover:underline">Log in</a> or
                    <a href="{{ route('register') }}" class="font-medium text-violet-600 hover:underline">create an account</a> to apply.
                </p>
            @elseif($myApplication)
                <div class="flex items-center gap-3 rounded-lg border border-green-200 bg-green-50 px-4 py-3">
                    <svg class="h-5 w-5 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div>
                        <p class="text-sm font-medium text-green-800">Application submitted</p>
                        <p class="text-xs text-green-600 mt-0.5">{{ $myApplication->created_at->format('d M Y') }}
                            @if($myApplication->status !== 'pending')
                                · Status: <span class="font-medium capitalize">{{ $myApplication->status }}</span>
                            @endif
                        </p>
                    </div>
                </div>
            @elseif($brief->status !== 'open' || ($brief->expires_at && $brief->expires_at->isPast()))
                <p class="text-sm text-zinc-500">This brief is no longer accepting applications.</p>
            @else
                <div class="space-y-4">
                    {{-- Pitch text --}}
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-zinc-700">Your pitch <span class="text-red-500">*</span></label>
                        <textarea wire:model="pitchText" rows="5" maxlength="2000"
                                  placeholder="Introduce yourself, describe your relevant experience, and explain why you'd be a great fit for this project…"
                                  class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2.5 text-sm text-zinc-900 placeholder-zinc-400 focus:border-violet-400 focus:outline-none focus:ring-2 focus:ring-violet-100 resize-none"></textarea>
                        @error('pitchText') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Portfolio item --}}
                    @if($myPortfolioItems->count())
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-zinc-700">Attach a portfolio item <span class="text-zinc-400 font-normal">(optional)</span></label>
                            <select wire:model="portfolioItemId"
                                    class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2.5 text-sm text-zinc-700 focus:border-violet-400 focus:outline-none focus:ring-2 focus:ring-violet-100">
                                <option value="">No attachment</option>
                                @foreach($myPortfolioItems as $item)
                                    <option value="{{ $item->id }}">{{ $item->title }}</option>
                                @endforeach
                            </select>
                            @error('portfolioItemId') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                    @endif

                    <button wire:click="apply" wire:loading.attr="disabled"
                            class="w-full rounded-lg bg-violet-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-violet-700 disabled:opacity-60 transition">
                        <span wire:loading.remove wire:target="apply">Submit application</span>
                        <span wire:loading wire:target="apply">Submitting…</span>
                    </button>
                </div>
            @endif
        </div>
    @endif

    {{-- ── Applications (poster only) ────────────────────────────────────── --}}
    @if($isOwner && $brief->applications->count())
        <div class="rounded-xl border border-zinc-200 bg-white p-6 space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-base font-semibold text-zinc-900">Applications</h2>
                <span class="rounded-full bg-zinc-100 px-2.5 py-0.5 text-xs font-medium text-zinc-600">{{ $brief->applications->count() }}</span>
            </div>

            <div class="divide-y divide-zinc-100">
                @foreach($brief->applications->sortByDesc('created_at') as $application)
                    @php $applicant = $application->applicant; @endphp
                    <div class="py-4 space-y-3">
                        {{-- Applicant header --}}
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-center gap-2 min-w-0">
                                <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-violet-100 text-[11px] font-bold text-violet-700">
                                    {{ strtoupper(substr($applicant?->profile?->display_name ?? $applicant?->name ?? '?', 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-medium text-zinc-900">{{ $applicant?->profile?->display_name ?? $applicant?->name }}</p>
                                    <p class="text-xs text-zinc-400">{{ $application->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            {{-- Status badge --}}
                            <span class="shrink-0 rounded-full px-2.5 py-0.5 text-xs font-medium
                                {{ $application->status === 'shortlisted' ? 'bg-green-100 text-green-700' : ($application->status === 'rejected' ? 'bg-red-100 text-red-600' : 'bg-zinc-100 text-zinc-500') }}">
                                {{ ucfirst($application->status) }}
                            </span>
                        </div>

                        {{-- Pitch --}}
                        <p class="text-sm text-zinc-600 whitespace-pre-wrap">{{ $application->pitch_text }}</p>

                        {{-- Portfolio item --}}
                        @if($application->portfolioItem)
                            <div class="flex items-center gap-2 rounded-lg border border-zinc-100 bg-zinc-50 px-3 py-2">
                                <svg class="h-4 w-4 text-zinc-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                <span class="text-xs text-zinc-600">{{ $application->portfolioItem->title }}</span>
                                @if($application->portfolioItem->url)
                                    <a href="{{ $application->portfolioItem->url }}" target="_blank" rel="noopener"
                                       class="ml-auto text-xs text-violet-600 hover:underline shrink-0">Listen</a>
                                @endif
                            </div>
                        @endif

                        {{-- Actions --}}
                        @if($brief->status === 'open')
                            <div class="flex items-center gap-2">
                                @if($application->status !== 'shortlisted')
                                    <button wire:click="updateApplicationStatus({{ $application->id }}, 'shortlisted')"
                                            class="rounded-lg border border-green-200 bg-green-50 px-3 py-1 text-xs font-medium text-green-700 hover:bg-green-100 transition">
                                        Shortlist
                                    </button>
                                @endif
                                @if($application->status !== 'pending')
                                    <button wire:click="updateApplicationStatus({{ $application->id }}, 'pending')"
                                            class="rounded-lg border border-zinc-200 px-3 py-1 text-xs font-medium text-zinc-600 hover:border-zinc-300 transition">
                                        Reset
                                    </button>
                                @endif
                                @if($application->status !== 'rejected')
                                    <button wire:click="updateApplicationStatus({{ $application->id }}, 'rejected')"
                                            class="rounded-lg border border-red-100 bg-red-50 px-3 py-1 text-xs font-medium text-red-600 hover:bg-red-100 transition">
                                        Decline
                                    </button>
                                @endif
                                @if($applicant?->profile)
                                    <a href="{{ route('profile.show', $applicant->profile) }}" wire:navigate
                                       class="ml-auto text-xs text-violet-600 hover:underline">View profile</a>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @elseif($isOwner)
        <div class="flex flex-col items-center gap-2 rounded-xl border border-zinc-100 bg-zinc-50 py-10 text-center">
            <svg class="h-8 w-8 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <p class="text-sm text-zinc-500">No applications yet.</p>
        </div>
    @endif

</div>
