<div>
    <h1 class="mb-2 text-2xl font-bold">Choose your plan</h1>
    <p class="mb-8 text-sm text-zinc-400">All paid plans are fixed-term — no recurring billing. Pay once, full access for the term.</p>

    @php
        $plans = [
            'free' => [
                'label' => 'Free',
                'price' => null,
                'features' => ['Verified profile', 'Free messaging', 'Up to 3 portfolio items', 'Browse & apply to briefs'],
            ],
            'pro' => [
                'label' => 'Pro',
                'annual' => 80, 'six_month' => 45, 'three_month' => 25,
                'features' => ['Everything in Free', 'Unlimited portfolio items', 'Profile analytics', '2× search visibility boost', 'Pay per brief post'],
            ],
            'pro_plus' => [
                'label' => 'Pro+',
                'annual' => 180, 'six_month' => 100, 'three_month' => 55,
                'features' => ['Everything in Pro', '3× search visibility boost', 'Post briefs free (included)', 'Priority in search results'],
            ],
        ];
        $termLabels = ['annual' => 'Annual', 'six_month' => '6 months', 'three_month' => '3 months'];
    @endphp

    {{-- Term selector (only relevant for paid plans) --}}
    @if($selectedPlan !== 'free')
        <div class="mb-6 flex gap-2 rounded-xl border border-zinc-700 bg-zinc-900 p-1">
            @foreach($termLabels as $term => $label)
                <button
                    wire:click="$set('selectedTerm', '{{ $term }}')"
                    class="flex-1 rounded-lg py-2 text-sm font-medium transition-colors
                        {{ $selectedTerm === $term ? 'bg-brand text-white' : 'text-zinc-400 hover:text-zinc-200' }}"
                >
                    {{ $label }}
                    @if($term === 'annual') <span class="ml-1 text-xs opacity-75">Best value</span> @endif
                </button>
            @endforeach
        </div>
    @endif

    <div class="space-y-3">
        @foreach($plans as $planKey => $plan)
            <button
                wire:click="$set('selectedPlan', '{{ $planKey }}')"
                class="w-full rounded-xl border px-5 py-4 text-left transition-colors
                    {{ $selectedPlan === $planKey
                        ? 'border-brand bg-brand/10'
                        : 'border-zinc-700 bg-zinc-900 hover:border-zinc-500' }}"
            >
                <div class="flex items-center justify-between">
                    <div class="font-semibold">{{ $plan['label'] }}</div>
                    <div class="text-right">
                        @if($plan['price'] === null)
                            <span class="text-lg font-bold">Free</span>
                        @else
                            <span class="text-lg font-bold">£{{ $plan[$selectedTerm] }}</span>
                            <span class="ml-1 text-xs text-zinc-500">/ {{ $termLabels[$selectedTerm] }}</span>
                        @endif
                    </div>
                </div>
                <ul class="mt-2 space-y-0.5">
                    @foreach($plan['features'] as $feature)
                        <li class="flex items-center gap-2 text-xs text-zinc-400">
                            <svg class="h-3.5 w-3.5 shrink-0 text-brand-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            {{ $feature }}
                        </li>
                    @endforeach
                </ul>
            </button>
        @endforeach
    </div>

    @if($selectedPlan !== 'free')
        <div class="mt-4 rounded-lg border border-zinc-700 bg-zinc-900/50 px-4 py-3 text-sm text-zinc-400">
            <strong class="text-white">Stripe payments coming soon.</strong>
            During development, selecting a paid plan will activate it without charging.
        </div>
    @endif

    <flux:button wire:click="selectPlan" variant="primary" class="mt-6 w-full">
        @if($selectedPlan === 'free')
            Join for free
        @else
            {{ $selectedPlan === 'pro_plus' ? 'Pro+' : 'Pro' }} — £{{ $plans[$selectedPlan][$selectedTerm] }} for {{ strtolower($termLabels[$selectedTerm]) }}
        @endif
    </flux:button>
</div>
