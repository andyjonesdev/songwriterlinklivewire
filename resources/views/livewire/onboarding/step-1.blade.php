<div>
    <h1 class="mb-2 text-2xl font-bold">What best describes you?</h1>
    <p class="mb-8 text-sm text-zinc-400">This helps us tailor your experience. You can update it later.</p>

    @php
        $roles = [
            'songwriter' => ['label' => 'Songwriter', 'desc' => 'You write lyrics and/or melodies'],
            'composer'   => ['label' => 'Composer', 'desc' => 'You create instrumental or orchestral work'],
            'producer'   => ['label' => 'Producer', 'desc' => 'You produce and arrange music'],
            'publisher'  => ['label' => 'Publisher / Label', 'desc' => 'You represent or sign artists'],
            'other'      => ['label' => 'Other', 'desc' => 'Another music industry role'],
        ];
    @endphp

    <div class="space-y-3">
        @foreach($roles as $value => $info)
            <button
                wire:click="$set('role', '{{ $value }}')"
                class="w-full rounded-xl border px-5 py-4 text-left transition-colors
                    {{ $role === $value
                        ? 'border-brand bg-brand/10 text-white'
                        : 'border-zinc-700 bg-zinc-900 text-zinc-300 hover:border-zinc-500' }}"
            >
                <div class="font-semibold">{{ $info['label'] }}</div>
                <div class="mt-0.5 text-xs text-zinc-400">{{ $info['desc'] }}</div>
            </button>
        @endforeach
    </div>

    @if(in_array($role, ['producer', 'publisher']))
        <div class="mt-4 rounded-lg border border-yellow-700/50 bg-yellow-900/20 px-4 py-3 text-sm text-yellow-300">
            Producers and publishers require additional verification after joining to display a verified badge.
        </div>
    @endif

    <flux:button wire:click="submitRole" variant="primary" class="mt-8 w-full">
        Continue
    </flux:button>

    <p class="mt-4 text-center text-sm text-zinc-500">
        Already a member? <a href="{{ route('login') }}" class="text-brand hover:underline" wire:navigate>Sign in</a>
    </p>
</div>
