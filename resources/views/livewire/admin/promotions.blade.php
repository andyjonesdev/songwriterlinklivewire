<div class="mx-auto max-w-4xl space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-zinc-900">Promotions</h1>
        <p class="mt-0.5 text-sm text-zinc-500">Manage promoted member profiles.</p>
    </div>

    @include('partials.admin-nav')

    {{-- Add promotion form --}}
    <div class="rounded-xl border border-zinc-200 bg-white p-5 space-y-4">
        <h3 class="text-sm font-semibold text-zinc-700">Add manual promotion</h3>
        @if($addError)
            <p class="text-sm text-red-600">{{ $addError }}</p>
        @endif
        <div class="flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-52">
                <label class="mb-1 block text-xs font-medium text-zinc-600">Member email</label>
                <input wire:model="addEmail" type="email" placeholder="member@example.com"
                       class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 placeholder-zinc-400 focus:border-violet-400 focus:outline-none focus:ring-2 focus:ring-violet-100" />
            </div>
            <div>
                <label class="mb-1 block text-xs font-medium text-zinc-600">Duration (days)</label>
                <input wire:model="addDays" type="number" min="1" max="365" value="30"
                       class="w-24 rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-700 focus:border-violet-400 focus:outline-none focus:ring-2 focus:ring-violet-100" />
            </div>
            <button wire:click="addPromotion"
                    class="rounded-lg bg-violet-600 px-4 py-2 text-sm font-semibold text-white hover:bg-violet-700 transition">
                Add promotion
            </button>
        </div>
    </div>

    {{-- Promotions list --}}
    @if($promotions->isEmpty())
        <div class="flex flex-col items-center gap-2 rounded-xl border border-zinc-100 bg-zinc-50 py-12 text-center">
            <p class="text-sm text-zinc-500">No promotions yet.</p>
        </div>
    @else
        <div class="rounded-xl border border-zinc-200 bg-white divide-y divide-zinc-100">
            @foreach($promotions as $promo)
                <div class="flex items-center justify-between gap-4 p-4">
                    <div class="flex-1 min-w-0 space-y-0.5">
                        <div class="flex flex-wrap items-center gap-2">
                            <p class="text-sm font-medium text-zinc-900">
                                {{ $promo->user?->profile?->display_name ?? $promo->user?->name ?? '–' }}
                            </p>
                            @if($promo->active && $promo->ends_at?->isFuture())
                                <span class="rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-700">Active</span>
                            @else
                                <span class="rounded-full bg-zinc-100 px-2 py-0.5 text-xs font-medium text-zinc-500">Ended</span>
                            @endif
                        </div>
                        <p class="text-xs text-zinc-400">{{ $promo->user?->email }}</p>
                        <p class="text-xs text-zinc-400">
                            {{ $promo->starts_at?->format('d M Y') }} – {{ $promo->ends_at?->format('d M Y') }}
                            @if($promo->ends_at?->isFuture() && $promo->active)
                                · ends {{ $promo->ends_at->diffForHumans() }}
                            @endif
                        </p>
                    </div>
                    @if($promo->active && $promo->ends_at?->isFuture())
                        <button wire:click="deactivate({{ $promo->id }})" wire:confirm="End this promotion early?"
                                class="shrink-0 rounded-lg border border-zinc-200 px-3 py-1.5 text-xs font-medium text-zinc-600 hover:border-zinc-300 transition">
                            End now
                        </button>
                    @endif
                </div>
            @endforeach
        </div>
        <div>{{ $promotions->links() }}</div>
    @endif
</div>
