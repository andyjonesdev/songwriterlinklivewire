<div>
    <flux:heading size="xl" class="text-center">Choose your plan</flux:heading>
    <flux:subheading class="text-center">Fixed-term, no recurring billing. Pay once, full access for the term.</flux:subheading>

    @if (session('status'))
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">{{ session('error') }}</div>
    @endif

    @php
        $plans = [
            'free'     => ['label' => 'Free',  'annual' => null, 'six_month' => null, 'three_month' => null],
            'pro'      => ['label' => 'Pro',   'annual' => 80,   'six_month' => 45,   'three_month' => 25],
            'pro_plus' => ['label' => 'Pro+',  'annual' => 180,  'six_month' => 100,  'three_month' => 55],
        ];
        $termLabels   = ['annual' => 'Annual', 'six_month' => '6 months', 'three_month' => '3 months'];
        $feePaid      = auth()->user()->joining_fee_paid;
        $recommended  = $feePaid ? 'pro' : null; // highlight Pro when joining fee was paid
    @endphp

    {{-- Term switcher (hidden for free) --}}
    @if($selectedPlan !== 'free')
        <div class="flex gap-1 rounded-lg border border-zinc-200 bg-zinc-50 p-1">
            @foreach($termLabels as $term => $label)
                <button wire:click="$set('selectedTerm', '{{ $term }}')" type="button"
                    class="flex-1 rounded-md py-1.5 text-xs font-medium transition-colors
                        {{ $selectedTerm === $term ? 'bg-white text-zinc-900 shadow-sm' : 'text-zinc-500 hover:text-zinc-700' }}">
                    {{ $label }}@if($term === 'annual') <span class="text-violet-500"> ★ Best value</span>@endif
                </button>
            @endforeach
        </div>
    @endif

    {{-- Plan cards --}}
    <div class="grid grid-cols-3 gap-2">
        @foreach($plans as $planKey => $plan)
            <button wire:click="$set('selectedPlan', '{{ $planKey }}')" type="button"
                class="relative rounded-lg border px-3 py-3 text-center transition-colors
                    {{ $selectedPlan === $planKey ? 'border-violet-400 bg-violet-50 ring-1 ring-violet-300' : 'border-zinc-200 bg-white hover:border-zinc-300' }}">
                @if($recommended === $planKey)
                    <span class="absolute -top-2.5 left-1/2 -translate-x-1/2 whitespace-nowrap rounded-full bg-violet-600 px-2 py-0.5 text-[10px] font-semibold text-white">Recommended</span>
                @endif
                <div class="text-sm font-bold text-zinc-900">{{ $plan['label'] }}</div>
                <div class="mt-1 text-lg font-bold text-zinc-900">
                    @if($plan['annual'] === null)
                        <span class="text-base">Free</span>
                    @else
                        £{{ $plan[$selectedTerm] }}
                    @endif
                </div>
                @if($plan['annual'] !== null)
                    <div class="text-xs text-zinc-400">{{ strtolower($termLabels[$selectedTerm]) }}</div>
                @endif
            </button>
        @endforeach
    </div>

    {{-- Feature comparison table --}}
    <div class="overflow-x-auto rounded-lg border border-zinc-200">
        <table class="w-full text-xs">
            <thead>
                <tr class="border-b border-zinc-200 bg-zinc-50">
                    <th class="px-3 py-2 text-left font-medium text-zinc-500">Feature</th>
                    <th class="px-3 py-2 text-center font-medium {{ $selectedPlan === 'free' ? 'text-violet-600' : 'text-zinc-500' }}">Free</th>
                    <th class="px-3 py-2 text-center font-medium {{ $selectedPlan === 'pro' ? 'text-violet-600' : 'text-zinc-500' }}">Pro</th>
                    <th class="px-3 py-2 text-center font-medium {{ $selectedPlan === 'pro_plus' ? 'text-violet-600' : 'text-zinc-500' }}">Pro+</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-100">
                @php
                    $tick   = '<svg class="mx-auto h-3.5 w-3.5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>';
                    $cross  = '<span class="text-zinc-300">—</span>';
                    $rows = [
                        ['Messaging',                    'Full',      'Full',      'Full'],
                        ['Portfolio uploads',            '3',         'Unlimited', 'Unlimited'],
                        ['Profile analytics',            $cross,      $tick,       $tick],
                        ['Search boost',                 $cross,      $tick,       $tick],
                        ['Credits page / CV export',     $cross,      $tick,       $tick],
                        ['Split sheet generator',        $cross,      $tick,       $tick],
                        ['Verified industry badge',      $cross,      $tick,       $tick],
                        ['Post briefs',                  '£7/post',   '£7/post',   'Free'],
                        ['Open briefs simultaneously',   '1',         '1',         'Up to 5'],
                        ['Applicant pipeline view',      'Basic list','Basic list','Full UI'],
                        ['Application alerts',           '1hr delay', '1hr delay', 'Immediate'],
                        ['View member social links',     $cross,      $cross,      $tick],
                        ['Bulk message brief matches',   $cross,      $cross,      $tick],
                        ['Promoted profile (included)',  $cross,      $cross,      '1/term'],
                        ['Priority support',             $cross,      $cross,      $tick],
                        ['Producer / publisher badge',   $cross,      $cross,      $tick],
                    ];
                @endphp
                @foreach($rows as $row)
                    <tr class="hover:bg-zinc-50">
                        <td class="px-3 py-1.5 text-zinc-600">{{ $row[0] }}</td>
                        <td class="px-3 py-1.5 text-center text-zinc-700 {{ $selectedPlan === 'free' ? 'bg-violet-50/50' : '' }}">{!! $row[1] !!}</td>
                        <td class="px-3 py-1.5 text-center text-zinc-700 {{ $selectedPlan === 'pro' ? 'bg-violet-50/50' : '' }}">{!! $row[2] !!}</td>
                        <td class="px-3 py-1.5 text-center text-zinc-700 {{ $selectedPlan === 'pro_plus' ? 'bg-violet-50/50' : '' }}">{!! $row[3] !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- CTA --}}
    <div class="pt-2 border-t border-zinc-100"></div>
    @if($selectedPlan === 'free')
        <flux:button wire:click="selectPlan" variant="primary" class="w-full">
            Join for free
        </flux:button>
    @else
        {{-- Real Stripe button --}}
        <a href="{{ route('checkout.subscription.start', ['plan' => $selectedPlan, 'term' => $selectedTerm]) }}"
           class="flex w-full items-center justify-center gap-2 rounded-lg bg-violet-600 px-4 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
            {{ $selectedPlan === 'pro_plus' ? 'Pro+' : 'Pro' }} — £{{ $plans[$selectedPlan][$selectedTerm] }} / {{ strtolower($termLabels[$selectedTerm]) }}
        </a>
        <p class="text-center text-xs text-zinc-400">Secure payment via Stripe. No recurring billing — one payment, full access for the term.</p>

        @if(app()->isLocal())
            <div class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
                <strong>Dev mode:</strong>
                <button wire:click="selectPlanDev" class="ml-1 font-semibold underline hover:no-underline">Activate {{ $selectedPlan === 'pro_plus' ? 'Pro+' : 'Pro' }} without paying →</button>
            </div>
        @endif
    @endif
</div>
