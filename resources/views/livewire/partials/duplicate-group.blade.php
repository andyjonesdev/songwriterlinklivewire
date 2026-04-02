<div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4">
    <h3 class="text-base font-semibold mb-3 text-red-800">
        {{ $label }}
        <span class="text-sm font-normal text-red-500">({{ $group->count() }} copies)</span>
    </h3>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-red-200 text-left text-gray-500">
                    <th class="pb-2 pr-4">ID</th>
                    <th class="pb-2 pr-4">Title</th>
                    <th class="pb-2 pr-4">Author</th>
                    <th class="pb-2 pr-4">Status</th>
                    <th class="pb-2 pr-4">AI Confidence</th>
                    <th class="pb-2 pr-4">Uploaded</th>
                    <th class="pb-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($group as $lyric)
                    <tr class="border-b border-red-100 last:border-0">
                        <td class="py-2 pr-4 text-gray-400">#{{ $lyric->id }}</td>
                        <td class="py-2 pr-4 font-medium">{{ $lyric->title }}</td>
                        <td class="py-2 pr-4">{{ $lyric->user->name ?? '—' }}</td>
                        <td class="py-2 pr-4">
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                                {{ $lyric->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ ucfirst($lyric->status) }}
                            </span>
                        </td>
                        <td class="py-2 pr-4">
                            @if ($lyric->ai_confidence !== null)
                                <span class="font-semibold {{ $lyric->ai_confidence >= 80 ? 'text-red-600' : ($lyric->ai_confidence >= 50 ? 'text-orange-500' : 'text-gray-400') }}">
                                    {{ $lyric->ai_confidence }}%
                                </span>
                            @else
                                <span class="text-gray-400">Unchecked</span>
                            @endif
                        </td>
                        <td class="py-2 pr-4 text-gray-500">{{ $lyric->created_at->format('d M Y, H:i') }}</td>
                        <td class="py-2">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('lyrics.show', $lyric->slug) }}"
                                   target="_blank"
                                   class="text-blue-600 hover:underline text-sm whitespace-nowrap">
                                    View
                                </a>
                                <button
                                    wire:click="delete({{ $lyric->id }})"
                                    onclick="return confirm('Permanently delete \"{{ addslashes($lyric->title) }}\" (#{{ $lyric->id }})? This cannot be undone.')"
                                    class="bg-red-600 text-white text-sm px-2 py-1 rounded hover:bg-red-700">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
