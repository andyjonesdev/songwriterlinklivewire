<div class="text-center">
    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-violet-100">
        <svg class="h-8 w-8 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </div>

    <flux:heading size="xl">Welcome to SongwriterLink!</flux:heading>
    <flux:subheading>You're now part of a verified network of music industry professionals.</flux:subheading>

    <div class="mt-4 space-y-2 text-left">
        @foreach([
            ['Next', 'Complete your profile', 'Add more detail to attract the right connections'],
            ['Discover', 'Browse members', 'Find songwriters, producers, and publishers'],
            ['Collaborate', 'Check the brief board', 'Apply to co-write, sync, and session opportunities'],
        ] as [$label, $title, $desc])
            <div class="rounded-lg border border-zinc-200 bg-zinc-50 px-4 py-3">
                <div class="text-xs font-semibold uppercase tracking-wider text-zinc-400">{{ $label }}</div>
                <div class="text-sm font-medium text-zinc-900">{{ $title }}</div>
                <div class="text-xs text-zinc-500">{{ $desc }}</div>
            </div>
        @endforeach
    </div>

    <a href="{{ route('dashboard') }}" wire:navigate
        class="mt-6 inline-flex items-center gap-2 rounded-lg bg-violet-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-violet-700">
        Go to your dashboard
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
    </a>
</div>
