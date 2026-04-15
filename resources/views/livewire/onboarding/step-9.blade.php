<div>
    <flux:heading size="xl" class="text-center">Choose your plan</flux:heading>
    <flux:subheading class="text-center">Fixed-term, no recurring billing. Pay once, full access for the term.</flux:subheading>

    @php
        $plans = [
            'free'     => ['label' => 'Free',  'price' => null, 'annual' => null, 'six_month' => null, 'three_month' => null, 'features' => ['Verified profile', 'Free messaging', 'Up to 3 portfolio items', 'Browse & apply to briefs']],
            'pro'      => ['label' => 'Pro',   'annual' => 80,  'six_month' => 45, 'three_month' => 25, 'features' => ['Everything in Free', 'Unlimited portfolio', 'Profile analytics', '2× search boost', 'Pay per brief post']],
            'pro_plus' => ['label' => 'Pro+',  'annual' => 180, 'six_month' => 100,'three_month' => 55, 'features' => ['Everything in Pro', '3× search boost', 'Post briefs free', 'Priority in results']],
        ];
        $termLabels = ['annual' => 'Annual', 'six_month' => '6 months', 'three_month' => '3 months'];
    @endphp

    @if($selectedPlan !== 'free')
        <div class="flex gap-1 rounded-lg border border-zinc-200 bg-zinc-50 p-1">
            @foreach($termLabels as $term => $label)
                <button wire:click="$set('selectedTerm', '{{ $term }}')" type="button"
                    class="flex-1 rounded-md py-1.5 text-xs font-medium transition-colors
                        {{ $selectedTerm === $term ? 'bg-white text-zinc-900 shadow-sm' : 'text-zinc-500 hover:text-zinc-700' }}">
                    {{ $label }}@if($term === 'annual') <span class="text-violet-500"> ★</span>@endif
                </button>
            @endforeach
        </div>
    @endif

    <div class="space-y-2">
        @foreach($plans as $planKey => $plan)
            <button wire:click="$set('selectedPlan', '{{ $planKey }}')" type="button"
                class="w-full rounded-lg border px-4 py-3 text-left transition-colors
                    {{ $selectedPlan === $planKey ? 'border-violet-400 bg-violet-50' : 'border-zinc-200 bg-white hover:border-zinc-300' }}">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-semibold text-zinc-900">{{ $plan['label'] }}</span>
                    <span class="text-sm font-bold text-zinc-900">
                        @if($plan['price'] === null && $plan['annual'] === null) Free
                        @else £{{ $plan[$selectedTerm] }} <span class="text-xs font-normal text-zinc-400">/ {{ strtolower($termLabels[$selectedTerm]) }}</span>
                        @endif
                    </span>
                </div>
                <ul class="mt-1.5 space-y-0.5">
                    @foreach($plan['features'] as $f)
                        <li class="flex items-center gap-1.5 text-xs text-zinc-500">
                            <svg class="h-3 w-3 shrink-0 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            {{ $f }}
                        </li>
                    @endforeach
                </ul>
            </button>
        @endforeach
    </div>

    @if($selectedPlan !== 'free')
        <p class="text-center text-xs text-amber-600">Stripe payments coming soon — selecting a paid plan activates it without charging during development.</p>
    @endif

    <flux:button wire:click="selectPlan" variant="primary" class="w-full">
        @if($selectedPlan === 'free') Join for free
        @else {{ $selectedPlan === 'pro_plus' ? 'Pro+' : 'Pro' }} — £{{ $plans[$selectedPlan][$selectedTerm] }} for {{ strtolower($termLabels[$selectedTerm]) }}
        @endif
    </flux:button>
</div>
