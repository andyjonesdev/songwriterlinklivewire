<div>
    <flux:heading size="xl" class="text-center">Verify your identity</flux:heading>
    <flux:subheading class="text-center">SongwriterLink requires government ID verification. Handled securely by Stripe — we never see your documents.</flux:subheading>

    <div class="space-y-2">
        <div class="flex items-start gap-3 rounded-lg border border-zinc-200 bg-zinc-50 p-4">
            <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-violet-100">
                <svg class="h-4 w-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <div>
                <div class="text-sm font-medium text-zinc-900">Government-issued ID</div>
                <div class="text-xs text-zinc-500">Passport, driving licence, or national ID card</div>
            </div>
        </div>
        <div class="flex items-start gap-3 rounded-lg border border-zinc-200 bg-zinc-50 p-4">
            <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-violet-100">
                <svg class="h-4 w-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <div>
                <div class="text-sm font-medium text-zinc-900">Secure &amp; private</div>
                <div class="text-xs text-zinc-500">Stripe stores your documents. SongwriterLink only receives a verified / not-verified result.</div>
            </div>
        </div>
    </div>

    <div class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
        <strong>Stripe Identity coming soon.</strong> During development you can continue without completing ID verification.
    </div>

    <flux:button wire:click="skipIdVerification" variant="primary" class="w-full">
        Continue (dev mode)
    </flux:button>
</div>
