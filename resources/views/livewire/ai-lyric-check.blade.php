<div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
    <div class="relative flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">

        <h1 class="text-2xl font-bold mb-6">AI Lyric Check</h1>

        {{-- Stats --}}
        <div class="grid grid-cols-3 gap-4 mb-8">
            <div class="rounded-lg border border-sidebar-border/70 dark:border-sidebar-border p-4 text-center">
                <div class="text-3xl font-bold">{{ $total }}</div>
                <div class="text-sm text-gray-500 mt-1">Total Lyrics</div>
            </div>
            <div class="rounded-lg border border-yellow-400 p-4 text-center">
                <div class="text-3xl font-bold text-yellow-500">{{ $unchecked }}</div>
                <div class="text-sm text-gray-500 mt-1">Unchecked</div>
            </div>
            <div class="rounded-lg border border-red-400 p-4 text-center">
                <div class="text-3xl font-bold text-red-500">{{ $flagged }}</div>
                <div class="text-sm text-gray-500 mt-1">AI Flagged</div>
            </div>
        </div>

        {{-- Action --}}
        <div class="mb-8">
            @if ($message)
                <div class="mb-4 text-green-600">{{ $message }}</div>
            @endif
            @if ($error)
                <div class="mb-4 p-3 bg-red-50 border border-red-300 rounded text-red-700 text-sm font-mono">{{ $error }}</div>
            @endif

            <button
                wire:click="runCheck"
                wire:loading.attr="disabled"
                wire:loading.class="opacity-50 cursor-not-allowed"
                class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700"
            >
                <span wire:loading.remove wire:target="runCheck">Check Next 10 Unchecked Lyrics ({{ $unchecked }} remaining)</span>
                <span wire:loading wire:target="runCheck">Checking... this may take a moment</span>
            </button>
        </div>

        {{-- Flagged lyrics table --}}
        @if ($lyrics->isNotEmpty())
            <h2 class="text-lg font-semibold mb-3">Flagged Lyrics</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-sidebar-border/70 dark:border-sidebar-border text-left text-gray-500">
                            <th class="pb-2 pr-4">Title</th>
                            <th class="pb-2 pr-4">Author</th>
                            <th class="pb-2 pr-4">Confidence</th>
                            <th class="pb-2 pr-4">Reason</th>
                            <th class="pb-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lyrics as $lyric)
                            <tr class="border-b border-sidebar-border/70 dark:border-sidebar-border {{ $lyric->ai_approved ? 'opacity-50' : '' }}">
                                <td class="py-2 pr-4 font-medium">{{ $lyric->title }}</td>
                                <td class="py-2 pr-4">{{ $lyric->user->name ?? '—' }}</td>
                                <td class="py-2 pr-4">
                                    @if ($lyric->ai_confidence !== null)
                                        <span class="font-semibold {{ $lyric->ai_confidence >= 75 ? 'text-red-600' : ($lyric->ai_confidence >= 50 ? 'text-orange-500' : 'text-gray-400') }}">
                                            {{ $lyric->ai_confidence }}%
                                        </span>
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="py-2 pr-4 text-gray-500 text-xs max-w-xs">{{ $lyric->ai_flag_reason ?? '—' }}</td>
                                <td class="py-2">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('lyrics.show', $lyric->slug) }}"
                                           target="_blank"
                                           class="text-blue-600 hover:underline text-sm whitespace-nowrap">
                                            View Lyric
                                        </a>
                                        @if ($lyric->ai_approved)
                                            <span class="text-green-600 text-sm font-semibold">✓ Approved</span>
                                        @else
                                            <button wire:click="approve({{ $lyric->id }})"
                                                    onclick="return confirm('Approve this lyric and make it visible on the site?')"
                                                    class="bg-green-600 text-white text-sm px-2 py-1 rounded hover:bg-green-700">
                                                Approve
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
