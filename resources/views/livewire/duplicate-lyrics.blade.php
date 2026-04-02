<div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
    <div class="relative flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">

        <h1 class="text-2xl font-bold mb-2">Duplicate Lyrics</h1>
        <p class="text-sm text-gray-500 mb-6">Lyrics where both the title and content are identical. The oldest entry is listed first.</p>

        @if ($message)
            <div class="mb-4 text-green-600 font-semibold">{{ $message }}</div>
        @endif

        @if (count($groups) === 0)
            <p class="text-gray-500">No duplicate lyrics found.</p>
        @else
            <p class="mb-6 text-sm font-semibold text-gray-700">{{ count($groups) }} duplicate group(s) found</p>

            @foreach ($groups as $group)
                @include('livewire.partials.duplicate-group', ['group' => $group, 'label' => $group->first()->title])
            @endforeach
        @endif

    </div>
</div>
