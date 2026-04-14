<div>
    <h1 class="mb-2 text-2xl font-bold">Verify your identity</h1>
    <p class="mb-8 text-sm text-zinc-400">
        SongwriterLink requires government ID verification for all members. This is handled securely by Stripe — we never see or store your documents.
    </p>

    <div class="mb-6 space-y-3">
        <div class="flex items-start gap-3 rounded-xl border border-zinc-700 bg-zinc-900 p-4">
            <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-brand/10">
                <svg class="h-4 w-4 text-brand-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <div>
                <div class="font-medium">Government-issued ID</div>
                <div class="mt-0.5 text-sm text-zinc-400">Passport, driving licence, or national ID card</div>
            </div>
        </div>
        <div class="flex items-start gap-3 rounded-xl border border-zinc-700 bg-zinc-900 p-4">
            <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-brand/10">
                <svg class="h-4 w-4 text-brand-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <div>
                <div class="font-medium">Secure &amp; private</div>
                <div class="mt-0.5 text-sm text-zinc-400">Stripe stores your documents. SongwriterLink only receives a verified/not-verified result.</div>
            </div>
        </div>
    </div>

    <div class="rounded-lg border border-zinc-700 bg-zinc-900/50 px-4 py-3 text-sm text-zinc-400">
        <strong class="text-white">Stripe Identity coming soon.</strong>
        During development you can continue without completing ID verification.
    </div>

    <div class="mt-6 space-y-3">
        {{-- TODO: Replace with Stripe Identity session creation (Phase 2, item 6) --}}
        <flux:button wire:click="skipIdVerification" variant="primary" class="w-full">
            Continue (dev mode)
        </flux:button>
    </div>
</div>
