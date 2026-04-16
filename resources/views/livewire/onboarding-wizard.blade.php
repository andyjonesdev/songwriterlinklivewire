<div class="flex flex-col gap-6">
    {{-- Progress bar --}}
    @php
        $stepLabels = [
            1 => 'Your role', 2 => 'Account', 3 => 'Joining fee',
            4 => 'ID check', 5 => 'Profile', 6 => 'Photo',
            7 => 'Portfolio', 8 => 'Plan', 9 => 'Done',
        ];
        $pct = round(($currentStep / 9) * 100);
    @endphp

    <div>
        {{-- Back button + step label row --}}
        <div class="mb-1.5 flex items-center justify-between text-xs text-zinc-400">
            <div class="flex items-center gap-2">
                @if($currentStep >= 4 && $currentStep <= 8)
                    <button wire:click="goBack" type="button" class="flex items-center gap-1 text-zinc-400 hover:text-zinc-600 transition-colors">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        Back
                    </button>
                    <span class="text-zinc-200">|</span>
                @endif
                <span>Step {{ $currentStep }} of 9 — {{ $stepLabels[$currentStep] ?? '' }}</span>
            </div>
            <span>{{ $pct }}%</span>
        </div>
        <div class="h-1 w-full overflow-hidden rounded-full bg-zinc-100">
            <div class="h-full rounded-full bg-violet-600 transition-all duration-500" style="width: {{ $pct }}%"></div>
        </div>
    </div>

    {{-- Step content --}}
    @include('livewire.onboarding.step-' . $currentStep)
</div>
