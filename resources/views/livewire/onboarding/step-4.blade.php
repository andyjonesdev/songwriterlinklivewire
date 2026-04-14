<div>
    <h1 class="mb-2 text-2xl font-bold">One-time joining fee</h1>
    <p class="mb-8 text-sm text-zinc-400">A one-time £4 fee helps us maintain a high-quality, verified community.</p>

    <div class="mb-6 rounded-xl border border-zinc-700 bg-zinc-900 p-6">
        <div class="flex items-center justify-between">
            <div>
                <div class="font-semibold">Joining fee</div>
                <div class="mt-0.5 text-sm text-zinc-400">One-time, non-refundable</div>
            </div>
            <div class="text-2xl font-bold">£4</div>
        </div>
    </div>

    <div class="rounded-lg border border-zinc-700 bg-zinc-900/50 px-4 py-3 text-sm text-zinc-400">
        <strong class="text-white">Stripe payment coming soon.</strong>
        During development you can continue without paying.
    </div>

    <div class="mt-6 space-y-3">
        {{-- TODO: Replace with Stripe Checkout redirect (Phase 2, item 8) --}}
        <flux:button wire:click="skipJoiningFee" variant="primary" class="w-full">
            Continue (dev mode)
        </flux:button>
    </div>
</div>
