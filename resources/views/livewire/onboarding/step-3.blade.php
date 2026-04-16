<div>
    <flux:heading size="xl" class="text-center">One-time joining fee</flux:heading>
    <flux:subheading class="text-center">A small one-time fee that helps us keep SongwriterLink free of bots and fake accounts.</flux:subheading>

    @if (session('status'))
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
        <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    @php $feePaid = auth()->user()->joining_fee_paid; @endphp

    @if ($feePaid)
        {{-- Already paid --}}
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            <div class="flex items-center gap-2">
                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Joining fee paid — thank you!
            </div>
        </div>
        <flux:button wire:click="skipJoiningFee" variant="primary" class="w-full">
            Continue →
        </flux:button>

    @else
        {{-- Fee summary --}}
        <div class="rounded-lg border border-zinc-200 bg-zinc-50 px-5 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm font-semibold text-zinc-900">SongwriterLink joining fee</div>
                    <div class="text-xs text-zinc-500">One-time &middot; non-refundable &middot; secure payment via Stripe</div>
                </div>
                <div class="text-2xl font-bold text-zinc-900">£4</div>
            </div>
        </div>

        {{-- Pay with Stripe --}}
        <a href="{{ route('checkout.joining-fee.start') }}"
           class="flex w-full items-center justify-center gap-2 rounded-lg bg-violet-600 px-4 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
            Pay £4 with Stripe
        </a>

        {{-- Waive with Pro/Pro+ --}}
        <div class="rounded-lg border border-zinc-200 bg-zinc-50 px-4 py-3">
            <div class="text-sm font-medium text-zinc-900 mb-1">Joining a paid plan?</div>
            <p class="text-xs text-zinc-500 mb-3">The joining fee is waived when you take out a Pro or Pro+ membership. You'll select your plan at step 8 — if you'd prefer to pay via your subscription, continue without paying now.</p>
            <button wire:click="waiveJoiningFeeForUpgrade" type="button"
                class="text-xs font-semibold text-violet-600 hover:underline">
                Skip — I'll pay as part of my Pro/Pro+ subscription →
            </button>
        </div>

        @if (app()->isLocal())
            <div class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
                <strong>Dev mode:</strong>
                <button wire:click="skipJoiningFee" class="ml-1 font-semibold underline hover:no-underline">Skip without paying →</button>
            </div>
        @endif
    @endif
</div>
