<x-layouts.app title="Brief">
    <div class="mx-auto max-w-xl">
        <div class="flex flex-col items-center gap-4 rounded-xl border border-zinc-100 bg-zinc-50 py-20 text-center">
            <svg class="h-10 w-10 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            <p class="text-sm font-medium text-zinc-500">Brief detail — coming soon</p>
            <a href="{{ route('briefs.index') }}" wire:navigate class="text-sm font-medium text-violet-600 hover:underline">← Back to Brief Board</a>
        </div>
    </div>
</x-layouts.app>
