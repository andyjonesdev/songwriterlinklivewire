<div>
    <flux:heading size="xl" class="text-center">One-time joining fee</flux:heading>
    <flux:subheading class="text-center">A one-time £4 fee helps us maintain a high-quality, verified community.</flux:subheading>

    <div class="rounded-lg border border-zinc-200 bg-zinc-50 px-5 py-4">
        <div class="flex items-center justify-between">
            <div>
                <div class="text-sm font-semibold text-zinc-900">Joining fee</div>
                <div class="text-xs text-zinc-500">One-time, non-refundable</div>
            </div>
            <div class="text-2xl font-bold text-zinc-900">£4</div>
        </div>
    </div>

    <div class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
        <strong>Stripe payment coming soon.</strong> During development you can continue without paying.
    </div>

    <flux:button wire:click="skipJoiningFee" variant="primary" class="w-full">
        Continue (dev mode)
    </flux:button>
</div>
