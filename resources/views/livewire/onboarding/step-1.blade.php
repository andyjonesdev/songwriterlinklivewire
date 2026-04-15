<div>
    <flux:heading size="xl" class="text-center">What best describes you?</flux:heading>
    <flux:subheading class="text-center">This helps us tailor your experience. You can update it later.</flux:subheading>

    @php
        $roles = [
            'songwriter' => ['label' => 'Songwriter', 'desc' => 'You write lyrics and/or melodies'],
            'composer'   => ['label' => 'Composer',   'desc' => 'You create instrumental or orchestral work'],
            'producer'   => ['label' => 'Producer',   'desc' => 'You produce and arrange music'],
            'publisher'  => ['label' => 'Publisher / Label', 'desc' => 'You represent or sign artists'],
            'other'      => ['label' => 'Other',      'desc' => 'Another music industry role'],
        ];
    @endphp

    <div class="space-y-2 mt-2">
        @foreach($roles as $value => $info)
            <button
                wire:click="$set('role', '{{ $value }}')"
                class="w-full rounded-lg border px-4 py-3 text-left transition-colors
                    {{ $role === $value
                        ? 'border-violet-500 bg-violet-50 text-zinc-900'
                        : 'border-zinc-200 bg-white text-zinc-700 hover:border-zinc-300 hover:bg-zinc-50' }}"
            >
                <div class="text-sm font-semibold">{{ $info['label'] }}</div>
                <div class="mt-0.5 text-xs text-zinc-500">{{ $info['desc'] }}</div>
            </button>
        @endforeach
    </div>

    @if(in_array($role, ['producer', 'publisher']))
        <div class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
            Producers and publishers require additional verification after joining to display a verified badge.
        </div>
    @endif

    <flux:button wire:click="submitRole" variant="primary" class="w-full">
        Continue
    </flux:button>

    <p class="text-center text-sm text-zinc-500">
        Already a member? <a href="{{ route('login') }}" class="text-violet-600 hover:underline" wire:navigate>Sign in</a>
    </p>
</div>
