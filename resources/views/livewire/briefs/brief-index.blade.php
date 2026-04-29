<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900">Brief Board</h1>
            <p class="mt-0.5 text-sm text-zinc-500">
                {{ $total }} open {{ Str::plural('brief', $total) }}
                @if($search || $category || $genre || $compensation) matching your filters @endif
            </p>
        </div>
        @if(auth()->user()->isPro())
            <a href="{{ route('briefs.create') }}" wire:navigate
               class="flex items-center gap-1.5 rounded-lg bg-violet-600 px-4 py-2 text-sm font-semibold text-white hover:bg-violet-700 transition">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Post a Brief
            </a>
        @else
            <a href="{{ route('onboarding.step', 8) }}" wire:navigate
               class="rounded-lg border border-violet-200 px-4 py-2 text-sm font-medium text-violet-700 hover:bg-violet-50 transition">
                Upgrade to post briefs
            </a>
        @endif
    </div>

    @if(session('error'))
        <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">{{ session('error') }}</div>
    @endif

    {{-- Filters --}}
    <div class="flex flex-wrap items-end gap-3">
        <div class="relative min-w-56 flex-1">
            <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input wire:model.live.debounce.300ms="search"
                   type="text"
                   placeholder="Search briefs…"
                   class="w-full rounded-lg border border-zinc-200 bg-white py-2 pl-9 pr-4 text-sm text-zinc-900 placeholder-zinc-400 focus:border-violet-400 focus:outline-none focus:ring-2 focus:ring-violet-100" />
        </div>

        <select wire:model.live="category"
                class="rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-700 focus:border-violet-400 focus:outline-none focus:ring-2 focus:ring-violet-100">
            <option value="">All categories</option>
            @foreach(\App\Livewire\Briefs\BriefIndex::categories() as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </select>

        <select wire:model.live="compensation"
                class="rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-700 focus:border-violet-400 focus:outline-none focus:ring-2 focus:ring-violet-100">
            <option value="">All compensation</option>
            @foreach(\App\Livewire\Briefs\BriefIndex::compensationTypes() as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </select>

        @if($search || $category || $genre || $compensation)
            <button wire:click="clearFilters"
                    class="flex items-center gap-1.5 rounded-lg border border-zinc-200 px-3 py-2 text-sm text-zinc-500 hover:border-zinc-300 hover:text-zinc-700 transition-colors">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                Clear
            </button>
        @endif
    </div>

    {{-- Loading --}}
    <div wire:loading.delay class="flex items-center gap-2 text-sm text-zinc-400">
        <svg class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
        </svg>
        Searching…
    </div>

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
    @endphp

    {{-- Brief grid --}}
    @if($briefs->count())
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($briefs as $brief)
                @php $poster = $brief->user; @endphp
                <a href="{{ route('briefs.show', $brief) }}" wire:navigate
                   class="group flex flex-col gap-3 rounded-xl border border-zinc-200 bg-white p-5 hover:border-violet-300 hover:shadow-sm transition-all">

                    {{-- Category badge --}}
                    <div class="flex items-center justify-between">
                        <span class="rounded-full px-2.5 py-0.5 text-xs font-medium {{ $categoryColors[$brief->category] ?? 'bg-zinc-100 text-zinc-700' }}">
                            {{ $categoryLabels[$brief->category] ?? $brief->category }}
                        </span>
                        @if($brief->deadline)
                            <span class="text-xs text-zinc-400">
                                Due {{ $brief->deadline->format('d M Y') }}
                            </span>
                        @endif
                    </div>

                    {{-- Title --}}
                    <h3 class="font-semibold text-zinc-900 group-hover:text-violet-700 transition-colors line-clamp-2">
                        {{ $brief->title }}
                    </h3>

                    {{-- Description excerpt --}}
                    <p class="text-xs text-zinc-500 line-clamp-2 flex-1">{{ $brief->description }}</p>

                    {{-- Footer --}}
                    <div class="flex items-center justify-between pt-2 border-t border-zinc-100">
                        {{-- Poster --}}
                        <div class="flex items-center gap-1.5 min-w-0">
                            <div class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-violet-100 text-[9px] font-bold text-violet-700">
                                {{ strtoupper(substr($poster?->profile?->display_name ?? $poster?->name ?? '?', 0, 1)) }}
                            </div>
                            <span class="truncate text-xs text-zinc-500">{{ $poster?->profile?->display_name ?? $poster?->name }}</span>
                        </div>

                        <div class="flex items-center gap-3 shrink-0">
                            {{-- Compensation --}}
                            <span class="text-xs text-zinc-400">{{ $compensationLabels[$brief->compensation_type] ?? '' }}</span>
                            {{-- Applications --}}
                            <span class="flex items-center gap-1 text-xs text-zinc-400">
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $brief->applications_count }}
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-4">{{ $briefs->links() }}</div>

    @else
        <div class="flex flex-col items-center gap-3 rounded-xl border border-zinc-100 bg-zinc-50 py-16 text-center">
            <svg class="h-10 w-10 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            <p class="text-sm font-medium text-zinc-500">No briefs found.</p>
            @if($search || $category || $genre || $compensation)
                <button wire:click="clearFilters" class="text-sm font-medium text-violet-600 hover:underline">Clear filters</button>
            @else
                <p class="text-xs text-zinc-400">Be the first to post one.</p>
            @endif
        </div>
    @endif
</div>
