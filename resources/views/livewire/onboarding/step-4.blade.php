<div>
    <flux:heading size="xl" class="text-center">Verify your identity</flux:heading>
    <flux:subheading class="text-center">Every SongwriterLink member is ID-verified. This builds the trust that makes the platform valuable.</flux:subheading>

    @if (session('status'))
        <div class="rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-700">
            {{ session('status') }}
        </div>
    @endif

    @php $idStatus = auth()->user()->id_verification_status; @endphp

    {{-- Under manual review --}}
    @if ($idStatus === 'review')
        <div class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
            <div class="font-semibold mb-1">Documents under review</div>
            Your ID documents are being reviewed by our team. This usually takes up to 48 hours. We'll email you once complete — no action needed from you right now.
        </div>

    {{-- Failed first attempt — offer retry --}}
    @elseif ($idStatus === 'failed')
        <div wire:poll.5s="pollIdentityStatus" class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <div class="font-semibold mb-1">Verification unsuccessful</div>
            We couldn't verify your identity from those documents. Please try again with a clear, in-date photo ID.
        </div>

        <a href="{{ route('identity.start') }}"
           class="flex w-full items-center justify-center gap-2 rounded-lg bg-violet-600 px-4 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            Try again with Stripe Identity
        </a>

    {{-- In progress — session created, polling for result --}}
    @elseif ($idStatus === 'pending')
        <div wire:poll.5s="pollIdentityStatus" class="rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-700">
            <div class="flex items-center gap-2">
                <svg class="h-4 w-4 animate-spin shrink-0" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                <span>Checking verification status&hellip; this page will update automatically.</span>
            </div>
        </div>

        <p class="text-center text-xs text-zinc-400">Completed the flow on your phone? Leave this page open — it'll detect your result within a few seconds.</p>

        <a href="{{ route('identity.start') }}"
           class="flex w-full items-center justify-center gap-2 rounded-lg border border-zinc-200 bg-white px-4 py-2.5 text-sm font-semibold text-zinc-700 shadow-xs hover:bg-zinc-50 transition">
            Restart verification
        </a>

    {{-- Not started yet --}}
    @else
        <div class="space-y-2">
            <div class="flex items-start gap-3 rounded-lg border border-zinc-200 bg-zinc-50 p-4">
                <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-violet-100">
                    <svg class="h-4 w-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2"/></svg>
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
                    <div class="text-xs text-zinc-500">Stripe handles your documents — SongwriterLink only receives a verified / not-verified result.</div>
                </div>
            </div>
            <div class="flex items-start gap-3 rounded-lg border border-zinc-200 bg-zinc-50 p-4">
                <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-violet-100">
                    <svg class="h-4 w-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <div class="text-sm font-medium text-zinc-900">Takes about 2 minutes</div>
                    <div class="text-xs text-zinc-500">Have your ID ready. You'll be taken to Stripe and brought straight back here.</div>
                </div>
            </div>
        </div>

        <a href="{{ route('identity.start') }}"
           class="flex w-full items-center justify-center gap-2 rounded-lg bg-violet-600 px-4 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            Verify my identity with Stripe
        </a>
    @endif

    @if (app()->isLocal())
        <div class="mt-2 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
            <strong>Dev mode:</strong> Stripe Identity requires live keys.
            <button wire:click="skipIdVerification" class="ml-1 font-semibold underline hover:no-underline">Skip for now →</button>
        </div>
    @endif
</div>
