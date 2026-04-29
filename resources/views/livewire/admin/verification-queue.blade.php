<div class="mx-auto max-w-5xl space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-zinc-900">Verification Queue</h1>
        <p class="mt-0.5 text-sm text-zinc-500">Review ID verification cases that need manual action.</p>
    </div>

    @include('partials.admin-nav')

    {{-- Filter tabs --}}
    <div class="flex gap-2">
        @foreach(['review' => 'Needs review', 'all_pending' => 'All pending', 'failed' => 'Failed'] as $value => $label)
            <button wire:click="$set('filter', '{{ $value }}')"
                    class="rounded-lg px-3 py-1.5 text-sm font-medium transition-colors
                           {{ $filter === $value ? 'bg-violet-600 text-white' : 'border border-zinc-200 bg-white text-zinc-600 hover:border-zinc-300' }}">
                {{ $label }}
            </button>
        @endforeach
    </div>

    @if($users->isEmpty())
        <div class="flex flex-col items-center gap-2 rounded-xl border border-zinc-100 bg-zinc-50 py-12 text-center">
            <svg class="h-8 w-8 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="text-sm text-zinc-500">All clear — no cases in this queue.</p>
        </div>
    @else
        <div class="rounded-xl border border-zinc-200 bg-white divide-y divide-zinc-100">
            @foreach($users as $u)
                <div class="flex items-center justify-between gap-4 p-4">
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-2 mb-0.5">
                            <p class="font-medium text-zinc-900">{{ $u->name }}</p>
                            <span class="rounded-full px-2 py-0.5 text-xs font-medium bg-amber-100 text-amber-700">
                                {{ $u->id_verification_status }}
                            </span>
                            <span class="text-xs text-zinc-400">{{ ucfirst($u->role) }}</span>
                        </div>
                        <p class="text-xs text-zinc-500">{{ $u->email }}</p>
                        @if($u->stripe_identity_session_id)
                            <p class="mt-0.5 font-mono text-[10px] text-zinc-400">Session: {{ $u->stripe_identity_session_id }}</p>
                        @endif
                        <p class="text-xs text-zinc-400">Joined {{ $u->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="flex shrink-0 items-center gap-2">
                        <button wire:click="approve({{ $u->id }})" wire:confirm="Approve this user's ID verification?"
                                class="rounded-lg bg-green-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-green-700 transition">
                            Approve
                        </button>
                        <button wire:click="reject({{ $u->id }})" wire:confirm="Reject this verification?"
                                class="rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-100 transition">
                            Reject
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
        <div>{{ $users->links() }}</div>
    @endif
</div>
