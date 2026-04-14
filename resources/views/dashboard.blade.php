<x-layouts.app :title="__('Dashboard')">
    <flux:main>
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">
                Welcome back, {{ auth()->user()->name }}
            </h1>
            <p class="mt-1 text-sm text-zinc-500">
                Member since {{ auth()->user()->created_at->format('F Y') }}
            </p>
        </div>

        {{-- Onboarding incomplete notice --}}
        @if(auth()->user()->status === 'pending')
            <div class="mb-6 rounded-xl border border-yellow-200 bg-yellow-50 p-4 dark:border-yellow-800 dark:bg-yellow-900/20">
                <p class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                    Your account verification is not yet complete.
                    <a href="{{ route('onboarding.step', auth()->user()->onboarding_step) }}" class="ml-1 underline">
                        Continue setup →
                    </a>
                </p>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            {{-- Profile card --}}
            <a href="{{ route('profile.show', auth()->user()->profile) }}" class="group rounded-xl border border-zinc-200 bg-white p-5 hover:border-brand/50 dark:border-zinc-700 dark:bg-zinc-900">
                <div class="mb-3 flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-brand/10 text-brand">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <h3 class="font-semibold text-zinc-900 dark:text-white">My Profile</h3>
                </div>
                <p class="text-sm text-zinc-500">View and edit your public profile</p>
            </a>

            {{-- Messages card --}}
            <a href="{{ route('messages.index') }}" class="group rounded-xl border border-zinc-200 bg-white p-5 hover:border-brand/50 dark:border-zinc-700 dark:bg-zinc-900">
                <div class="mb-3 flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-brand/10 text-brand">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </div>
                    <h3 class="font-semibold text-zinc-900 dark:text-white">Messages</h3>
                </div>
                <p class="text-sm text-zinc-500">Your conversations with other members</p>
            </a>

            {{-- Briefs card --}}
            <a href="{{ route('briefs.index') }}" class="group rounded-xl border border-zinc-200 bg-white p-5 hover:border-brand/50 dark:border-zinc-700 dark:bg-zinc-900">
                <div class="mb-3 flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-brand/10 text-brand">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <h3 class="font-semibold text-zinc-900 dark:text-white">Brief Board</h3>
                </div>
                <p class="text-sm text-zinc-500">Browse and post collaboration briefs</p>
            </a>
        </div>
    </flux:main>
</x-layouts.app>
