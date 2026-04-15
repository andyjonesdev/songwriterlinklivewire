<div class="flex flex-col gap-6">
    {{-- Progress bar --}}
    @php
        $stepLabels = [
            1 => 'Your role', 2 => 'Account', 3 => 'Phone',
            4 => 'Joining fee', 5 => 'ID check', 6 => 'Profile',
            7 => 'Photo', 8 => 'Portfolio', 9 => 'Plan', 10 => 'Done',
        ];
        $pct = round(($currentStep / 10) * 100);
    @endphp

    <div>
        <div class="mb-1.5 flex items-center justify-between text-xs text-zinc-400">
            <span>Step {{ $currentStep }} of 10 — {{ $stepLabels[$currentStep] ?? '' }}</span>
            <span>{{ $pct }}%</span>
        </div>
        <div class="h-1 w-full overflow-hidden rounded-full bg-zinc-100">
            <div class="h-full rounded-full bg-violet-600 transition-all duration-500" style="width: {{ $pct }}%"></div>
        </div>
    </div>

    {{-- Step content --}}
    @include('livewire.onboarding.step-' . $currentStep)
</div>
