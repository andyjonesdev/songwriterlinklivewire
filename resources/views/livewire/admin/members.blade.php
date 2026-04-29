<div class="mx-auto max-w-5xl space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-zinc-900">Members</h1>
        <p class="mt-0.5 text-sm text-zinc-500">Search and manage all platform members.</p>
    </div>

    @include('partials.admin-nav')

    {{-- Filters --}}
    <div class="flex flex-wrap items-end gap-3">
        <div class="relative min-w-56 flex-1">
            <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search by name or email…"
                   class="w-full rounded-lg border border-zinc-200 bg-white py-2 pl-9 pr-4 text-sm text-zinc-900 placeholder-zinc-400 focus:border-violet-400 focus:outline-none focus:ring-2 focus:ring-violet-100" />
        </div>
        <select wire:model.live="statusFilter"
                class="rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-700 focus:border-violet-400 focus:outline-none">
            <option value="">All statuses</option>
            <option value="active">Active</option>
            <option value="pending">Pending</option>
            <option value="suspended">Suspended</option>
            <option value="banned">Banned</option>
        </select>
        <select wire:model.live="tierFilter"
                class="rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-700 focus:border-violet-400 focus:outline-none">
            <option value="">All tiers</option>
            <option value="free">Free</option>
            <option value="pro">Pro</option>
            <option value="pro_plus">Pro+</option>
        </select>
    </div>

    <div class="rounded-xl border border-zinc-200 bg-white divide-y divide-zinc-100">
        @forelse($users as $u)
            <div class="flex items-center justify-between gap-4 px-4 py-3">
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-2">
                        <p class="text-sm font-medium text-zinc-900">{{ $u->name }}</p>
                        <span class="rounded-full px-2 py-0.5 text-xs font-medium
                            {{ $u->status === 'active' ? 'bg-green-100 text-green-700' : ($u->status === 'suspended' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                            {{ ucfirst($u->status) }}
                        </span>
                        <span class="text-xs text-zinc-400">{{ str_replace('_', '+', $u->subscription_tier) }}</span>
                        @if($u->id_verified)
                            <span class="text-xs text-violet-600">✓ ID verified</span>
                        @endif
                    </div>
                    <p class="text-xs text-zinc-400">{{ $u->email }} · Joined {{ $u->created_at->format('d M Y') }}</p>
                </div>
                <div class="flex shrink-0 items-center gap-2">
                    @if($u->profile)
                        <a href="{{ route('profile.show', $u->profile) }}" wire:navigate
                           class="rounded-lg border border-zinc-200 px-2.5 py-1 text-xs font-medium text-zinc-600 hover:border-zinc-300 transition">
                            Profile
                        </a>
                    @endif
                    @if($u->status === 'active')
                        <button wire:click="suspend({{ $u->id }})" wire:confirm="Suspend {{ $u->name }}?"
                                class="rounded-lg border border-red-200 bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600 hover:bg-red-100 transition">
                            Suspend
                        </button>
                    @elseif($u->status === 'suspended')
                        <button wire:click="reinstate({{ $u->id }})" wire:confirm="Reinstate {{ $u->name }}?"
                                class="rounded-lg border border-green-200 bg-green-50 px-2.5 py-1 text-xs font-medium text-green-600 hover:bg-green-100 transition">
                            Reinstate
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="py-12 text-center text-sm text-zinc-400">No members found.</div>
        @endforelse
    </div>

    <div>{{ $users->links() }}</div>
</div>
