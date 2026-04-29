<div class="mx-auto max-w-2xl space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-zinc-900">Subscription</h1>
        <p class="mt-1 text-sm text-zinc-500">Manage your SongwriterLink membership.</p>
    </div>

    @if(session('status'))
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('status') }}</div>
    @endif

    {{-- Current plan card --}}
    <div class="rounded-xl border border-zinc-200 bg-white p-6 space-y-4">
        <h2 class="text-base font-semibold text-zinc-900">Current plan</h2>

        @if($user->isProPlus())
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-600 text-white">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3l14 9-14 9V3z"/></svg>
                </div>
                <div>
                    <p class="font-semibold text-zinc-900">Pro+ Member</p>
                    <p class="text-sm text-zinc-500">Unlimited briefs · Priority placement · All Pro features</p>
                </div>
            </div>
        @elseif($user->isPro())
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-100">
                    <svg class="h-5 w-5 text-violet-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                </div>
                <div>
                    <p class="font-semibold text-zinc-900">Pro Member</p>
                    <p class="text-sm text-zinc-500">Post up to 3 open briefs · Full member directory access</p>
                </div>
            </div>
        @else
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-zinc-100">
                    <svg class="h-5 w-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div>
                    <p class="font-semibold text-zinc-900">Free Member</p>
                    <p class="text-sm text-zinc-500">Browse briefs · Apply to opportunities · Basic profile</p>
                </div>
            </div>
        @endif

        {{-- Expiry info --}}
        @if($user->subscription_expires_at)
            <div class="rounded-lg border border-zinc-100 bg-zinc-50 px-4 py-3 text-sm text-zinc-600">
                @if($user->subscription_expires_at->isFuture())
                    <span class="font-medium">Renews</span> {{ $user->subscription_expires_at->format('d M Y') }}
                    <span class="text-zinc-400 ml-1">({{ $user->subscription_expires_at->diffForHumans() }})</span>
                @else
                    <span class="text-red-600 font-medium">Expired</span> {{ $user->subscription_expires_at->format('d M Y') }}
                @endif
            </div>
        @endif
    </div>

    {{-- Upgrade / plan options --}}
    @if(!$user->isProPlus())
        <div class="rounded-xl border border-zinc-200 bg-white p-6 space-y-4">
            <h2 class="text-base font-semibold text-zinc-900">
                {{ $user->isPro() ? 'Upgrade to Pro+' : 'Upgrade your membership' }}
            </h2>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                @if(!$user->isPro())
                {{-- Pro plan --}}
                <div class="rounded-xl border-2 border-violet-200 p-5 space-y-3">
                    <div>
                        <p class="font-semibold text-zinc-900">Pro</p>
                        <p class="text-2xl font-bold text-zinc-900 mt-1">£9<span class="text-sm font-normal text-zinc-400">/mo</span></p>
                    </div>
                    <ul class="space-y-1.5 text-sm text-zinc-600">
                        <li class="flex items-center gap-2"><svg class="h-4 w-4 text-violet-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Post up to 3 open briefs</li>
                        <li class="flex items-center gap-2"><svg class="h-4 w-4 text-violet-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Full member directory</li>
                        <li class="flex items-center gap-2"><svg class="h-4 w-4 text-violet-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Direct messaging</li>
                        <li class="flex items-center gap-2"><svg class="h-4 w-4 text-violet-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Portfolio showcase</li>
                    </ul>
                    <a href="{{ route('checkout.subscription.start', ['plan' => 'pro', 'source' => 'settings', 'term' => 'annual']) }}"
                       class="block w-full rounded-lg bg-violet-600 px-4 py-2.5 text-center text-sm font-semibold text-white hover:bg-violet-700 transition">
                        Upgrade to Pro — £80/yr
                    </a>
                    <p class="text-center text-xs text-zinc-400">or <a href="{{ route('checkout.subscription.start', ['plan' => 'pro', 'source' => 'settings', 'term' => 'three_month']) }}" class="hover:underline">£25 / 3 months</a> · <a href="{{ route('checkout.subscription.start', ['plan' => 'pro', 'source' => 'settings', 'term' => 'six_month']) }}" class="hover:underline">£45 / 6 months</a></p>
                </div>
                @endif

                {{-- Pro+ plan --}}
                <div class="rounded-xl border-2 border-violet-500 p-5 space-y-3 relative">
                    <div class="absolute -top-3 left-4">
                        <span class="rounded-full bg-violet-600 px-3 py-0.5 text-[10px] font-bold uppercase tracking-wide text-white">Best value</span>
                    </div>
                    <div>
                        <p class="font-semibold text-zinc-900">Pro+</p>
                        <p class="text-2xl font-bold text-zinc-900 mt-1">£15<span class="text-sm font-normal text-zinc-400">/mo</span></p>
                    </div>
                    <ul class="space-y-1.5 text-sm text-zinc-600">
                        <li class="flex items-center gap-2"><svg class="h-4 w-4 text-violet-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Unlimited briefs</li>
                        <li class="flex items-center gap-2"><svg class="h-4 w-4 text-violet-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Priority listing placement</li>
                        <li class="flex items-center gap-2"><svg class="h-4 w-4 text-violet-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>All Pro features</li>
                        <li class="flex items-center gap-2"><svg class="h-4 w-4 text-violet-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Profile badge</li>
                    </ul>
                    <a href="{{ route('checkout.subscription.start', ['plan' => 'pro_plus', 'source' => 'settings', 'term' => 'annual']) }}"
                       class="block w-full rounded-lg bg-violet-600 px-4 py-2.5 text-center text-sm font-semibold text-white hover:bg-violet-700 transition">
                        Upgrade to Pro+ — £180/yr
                    </a>
                    <p class="text-center text-xs text-zinc-400">or <a href="{{ route('checkout.subscription.start', ['plan' => 'pro_plus', 'source' => 'settings', 'term' => 'three_month']) }}" class="hover:underline">£55 / 3 months</a> · <a href="{{ route('checkout.subscription.start', ['plan' => 'pro_plus', 'source' => 'settings', 'term' => 'six_month']) }}" class="hover:underline">£100 / 6 months</a></p>
                </div>
            </div>
        </div>
    @endif

    {{-- What's included (free tier) --}}
    @if(!$user->isPro())
        <div class="rounded-xl border border-zinc-100 bg-zinc-50 p-5">
            <p class="text-sm font-medium text-zinc-700 mb-3">Your current free access includes:</p>
            <ul class="space-y-1.5 text-sm text-zinc-600">
                <li class="flex items-center gap-2"><svg class="h-4 w-4 text-zinc-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Browse the Brief Board</li>
                <li class="flex items-center gap-2"><svg class="h-4 w-4 text-zinc-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Apply to open briefs</li>
                <li class="flex items-center gap-2"><svg class="h-4 w-4 text-zinc-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Public member profile</li>
            </ul>
        </div>
    @endif

</div>
