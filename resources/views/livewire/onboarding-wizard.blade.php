<div>
    {{-- Progress bar --}}
    @php
        $stepLabels = [
            1 => 'Your role',
            2 => 'Account',
            3 => 'Phone',
            4 => 'Joining fee',
            5 => 'ID check',
            6 => 'Profile',
            7 => 'Photo',
            8 => 'Portfolio',
            9 => 'Plan',
            10 => 'Done',
        ];
        $totalSteps = 10;
        $pct = round(($currentStep / $totalSteps) * 100);
    @endphp

    <div class="mb-8">
        <div class="mb-2 flex items-center justify-between text-xs text-zinc-500">
            <span>Step {{ $currentStep }} of {{ $totalSteps }} — {{ $stepLabels[$currentStep] ?? '' }}</span>
            <span>{{ $pct }}% complete</span>
        </div>
        <div class="h-1.5 w-full overflow-hidden rounded-full bg-zinc-800">
            <div class="h-full rounded-full bg-brand transition-all duration-500" style="width: {{ $pct }}%"></div>
        </div>
    </div>

    {{-- Step content --}}
    @include('livewire.onboarding.step-' . $currentStep)
</div>
