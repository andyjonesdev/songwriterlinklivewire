<div class="mx-auto max-w-5xl space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-zinc-900">Report Queue</h1>
        <p class="mt-0.5 text-sm text-zinc-500">Review member reports and take appropriate action.</p>
    </div>

    @include('partials.admin-nav')

    {{-- Filter tabs --}}
    <div class="flex gap-2">
        @foreach(['open' => 'Open', 'reviewed' => 'Reviewed', 'actioned' => 'Actioned', 'dismissed' => 'Dismissed', 'all' => 'All'] as $value => $label)
            <button wire:click="$set('filter', '{{ $value }}')"
                    class="rounded-lg px-3 py-1.5 text-sm font-medium transition-colors
                           {{ $filter === $value ? 'bg-violet-600 text-white' : 'border border-zinc-200 bg-white text-zinc-600 hover:border-zinc-300' }}">
                {{ $label }}
            </button>
        @endforeach
    </div>

    @if($reports->isEmpty())
        <div class="flex flex-col items-center gap-2 rounded-xl border border-zinc-100 bg-zinc-50 py-12 text-center">
            <svg class="h-8 w-8 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="text-sm text-zinc-500">No reports in this category.</p>
        </div>
    @else
        <div class="space-y-3">
            @foreach($reports as $report)
                <div class="rounded-xl border border-zinc-200 bg-white p-5 space-y-3">
                    <div class="flex items-start justify-between gap-4">
                        <div class="space-y-1 flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="rounded-full px-2.5 py-0.5 text-xs font-medium
                                    {{ $report->status === 'open' ? 'bg-red-100 text-red-700' : 'bg-zinc-100 text-zinc-500' }}">
                                    {{ ucfirst($report->status) }}
                                </span>
                                <span class="text-xs font-medium text-zinc-700">{{ str_replace('_', ' ', $report->reason) }}</span>
                                <span class="text-xs text-zinc-400">{{ $report->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="text-sm text-zinc-700">
                                <span class="font-medium">{{ $report->reporter?->name ?? '–' }}</span>
                                <span class="text-zinc-400"> reported </span>
                                <span class="font-medium">{{ $report->reportedUser?->name ?? '–' }}</span>
                                <span class="text-zinc-400 text-xs ml-1">({{ $report->reportedUser?->email }})</span>
                            </div>
                            @if($report->detail)
                                <p class="text-sm text-zinc-500 italic">"{{ $report->detail }}"</p>
                            @endif
                            <p class="text-xs text-zinc-400">
                                Reported user has {{ $report->reportedUser?->report_count ?? 0 }} total {{ Str::plural('report', $report->reportedUser?->report_count ?? 0) }}
                                · Status: {{ ucfirst($report->reportedUser?->status ?? '–') }}
                            </p>
                        </div>

                        @if($report->status === 'open')
                            <div class="flex shrink-0 flex-col gap-2">
                                <button wire:click="markReviewed({{ $report->id }})"
                                        class="rounded-lg border border-zinc-200 px-3 py-1.5 text-xs font-medium text-zinc-600 hover:border-zinc-300 transition">
                                    Mark reviewed
                                </button>
                                <button wire:click="dismiss({{ $report->id }})"
                                        class="rounded-lg border border-zinc-200 px-3 py-1.5 text-xs font-medium text-zinc-500 hover:border-zinc-300 transition">
                                    Dismiss
                                </button>
                                @if($report->reportedUser?->status === 'active')
                                    <button wire:click="suspendUser({{ $report->id }})"
                                            wire:confirm="Suspend {{ $report->reportedUser?->name }}? This will notify them by email."
                                            class="rounded-lg bg-red-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-red-700 transition">
                                        Suspend user
                                    </button>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <div>{{ $reports->links() }}</div>
    @endif
</div>
