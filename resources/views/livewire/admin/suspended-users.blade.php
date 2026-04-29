<div class="mx-auto max-w-5xl space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-zinc-900">Suspended Accounts</h1>
        <p class="mt-0.5 text-sm text-zinc-500">View suspended and banned members, and manage reinstatements.</p>
    </div>

    @include('partials.admin-nav')

    @if($users->isEmpty())
        <div class="flex flex-col items-center gap-2 rounded-xl border border-zinc-100 bg-zinc-50 py-12 text-center">
            <svg class="h-8 w-8 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="text-sm text-zinc-500">No suspended accounts.</p>
        </div>
    @else
        <div class="rounded-xl border border-zinc-200 bg-white divide-y divide-zinc-100">
            @foreach($users as $u)
                <div class="flex items-center justify-between gap-4 p-4">
                    <div class="flex-1 min-w-0 space-y-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <p class="font-medium text-zinc-900">{{ $u->name }}</p>
                            <span class="rounded-full px-2 py-0.5 text-xs font-medium
                                {{ $u->status === 'banned' ? 'bg-red-200 text-red-800' : 'bg-red-100 text-red-700' }}">
                                {{ ucfirst($u->status) }}
                            </span>
                        </div>
                        <p class="text-xs text-zinc-500">{{ $u->email }}</p>
                        @if($u->suspension_reason)
                            <p class="text-xs text-zinc-400 italic">"{{ $u->suspension_reason }}"</p>
                        @endif
                        <p class="text-xs text-zinc-400">{{ $u->report_count }} {{ Str::plural('report', $u->report_count) }} · Joined {{ $u->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="flex shrink-0 items-center gap-2">
                        @if($u->status === 'suspended')
                            <button wire:click="reinstate({{ $u->id }})" wire:confirm="Reinstate {{ $u->name }}?"
                                    class="rounded-lg bg-green-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-green-700 transition">
                                Reinstate
                            </button>
                            <button wire:click="ban({{ $u->id }})" wire:confirm="Escalate to permanent ban?"
                                    class="rounded-lg border border-red-300 bg-red-50 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-100 transition">
                                Ban
                            </button>
                        @else
                            <span class="text-xs text-zinc-400 italic">Permanently banned</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <div>{{ $users->links() }}</div>
    @endif
</div>
