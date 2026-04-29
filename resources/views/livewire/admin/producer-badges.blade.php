<div class="mx-auto max-w-5xl space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-zinc-900">Producer Badge Requests</h1>
        <p class="mt-0.5 text-sm text-zinc-500">Review and approve verified producer badge applications.</p>
    </div>

    @include('partials.admin-nav')

    <div class="flex gap-2">
        <button wire:click="$set('filter', 'pending')"
                class="rounded-lg px-3 py-1.5 text-sm font-medium transition-colors
                       {{ $filter === 'pending' ? 'bg-violet-600 text-white' : 'border border-zinc-200 bg-white text-zinc-600 hover:border-zinc-300' }}">
            Pending
        </button>
        <button wire:click="$set('filter', 'actioned')"
                class="rounded-lg px-3 py-1.5 text-sm font-medium transition-colors
                       {{ $filter !== 'pending' ? 'bg-violet-600 text-white' : 'border border-zinc-200 bg-white text-zinc-600 hover:border-zinc-300' }}">
            Actioned
        </button>
    </div>

    @if($users->isEmpty())
        <div class="flex flex-col items-center gap-2 rounded-xl border border-zinc-100 bg-zinc-50 py-12 text-center">
            <p class="text-sm text-zinc-500">No badge requests in this queue.</p>
        </div>
    @else
        <div class="rounded-xl border border-zinc-200 bg-white divide-y divide-zinc-100">
            @foreach($users as $u)
                <div class="flex items-center justify-between gap-4 p-4">
                    <div class="flex-1 min-w-0 space-y-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <p class="font-medium text-zinc-900">{{ $u->name }}</p>
                            <span class="rounded-full px-2 py-0.5 text-xs font-medium
                                {{ $u->producer_badge_status === 'approved' ? 'bg-green-100 text-green-700' : ($u->producer_badge_status === 'rejected' ? 'bg-red-100 text-red-600' : 'bg-amber-100 text-amber-700') }}">
                                {{ ucfirst($u->producer_badge_status) }}
                            </span>
                        </div>
                        <p class="text-xs text-zinc-500">{{ $u->email }}</p>
                        @if($u->producer_credit_url)
                            <a href="{{ $u->producer_credit_url }}" target="_blank" rel="noopener"
                               class="text-xs text-violet-600 hover:underline break-all">
                                {{ $u->producer_credit_url }}
                            </a>
                        @else
                            <p class="text-xs text-zinc-400 italic">No credit URL provided</p>
                        @endif
                        @if($u->profile)
                            <a href="{{ route('profile.show', $u->profile) }}" wire:navigate
                               class="text-xs text-zinc-400 hover:text-violet-600">View profile →</a>
                        @endif
                    </div>
                    @if($u->producer_badge_status === 'pending')
                        <div class="flex shrink-0 items-center gap-2">
                            <button wire:click="grant({{ $u->id }})" wire:confirm="Grant producer badge to {{ $u->name }}?"
                                    class="rounded-lg bg-green-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-green-700 transition">
                                Grant badge
                            </button>
                            <button wire:click="reject({{ $u->id }})"
                                    class="rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-100 transition">
                                Reject
                            </button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        <div>{{ $users->links() }}</div>
    @endif
</div>
