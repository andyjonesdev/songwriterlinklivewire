<div class="text-center">
    <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-brand/20">
        <svg class="h-10 w-10 text-brand-light" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </div>

    <h1 class="mb-3 text-3xl font-bold">Welcome to SongwriterLink!</h1>
    <p class="mx-auto mb-8 max-w-sm text-sm text-zinc-400">
        Your membership application is complete. You're now part of a verified network of music industry professionals.
    </p>

    <div class="mb-8 grid grid-cols-1 gap-3 text-left sm:grid-cols-3">
        <div class="rounded-xl border border-zinc-700 bg-zinc-900 p-4">
            <div class="mb-1 text-xs font-semibold uppercase tracking-wider text-zinc-500">Next</div>
            <div class="text-sm font-medium">Complete your profile</div>
            <div class="mt-0.5 text-xs text-zinc-500">Add more detail to attract the right connections</div>
        </div>
        <div class="rounded-xl border border-zinc-700 bg-zinc-900 p-4">
            <div class="mb-1 text-xs font-semibold uppercase tracking-wider text-zinc-500">Discover</div>
            <div class="text-sm font-medium">Browse members</div>
            <div class="mt-0.5 text-xs text-zinc-500">Find songwriters, producers, and publishers</div>
        </div>
        <div class="rounded-xl border border-zinc-700 bg-zinc-900 p-4">
            <div class="mb-1 text-xs font-semibold uppercase tracking-wider text-zinc-500">Collaborate</div>
            <div class="text-sm font-medium">Check the brief board</div>
            <div class="mt-0.5 text-xs text-zinc-500">Apply to co-write, sync, and session opportunities</div>
        </div>
    </div>

    <a href="{{ route('dashboard') }}" wire:navigate class="inline-flex items-center gap-2 rounded-lg bg-brand px-8 py-3 font-semibold text-white hover:bg-brand-dark">
        Go to your dashboard
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
    </a>
</div>
