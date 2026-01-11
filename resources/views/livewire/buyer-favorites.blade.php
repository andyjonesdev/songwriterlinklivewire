<div class="">
    <h1 class="text-2xl font-bold mb-4">Your Saved Lyrics</h1>

    @forelse ($favorites as $lyric)
        <div class="mb-8 lg:grid gap-6 rounded-xl border p-6 grid-cols-3">

            {{-- LEFT COLUMN --}}
            <div class="space-y-3">
                <h2 class="text-xl font-bold">
                    {{ $lyric->title }}
                </h2>

                <p class="text-sm text-gray-600">
                    Written by {{ $lyric->writer->name }}
                </p>

                <p>
                    <strong>Price:</strong>
                    ${{ number_format($lyric->price, 2) }}
                </p>

                <p class="text-sm text-gray-500">
                    Saved on {{ $lyric->pivot->created_at->format('M d, Y') }}
                </p>

                {{-- License notice --}}
                <h4 class="font-semibold text-sm">
                    License Notice
                </h4>

                <p class="text-sm text-gray-600">
                    Saving a lyric does not grant usage rights.
                    You must purchase a license before using this lyric.
                </p>

                {{-- Actions --}}
                <div class="flex gap-2 pt-3 mb-4">
                    {{-- Buy --}}
                    <a
                        href="{{ route('lyrics.show', $lyric->slug) }}"
                        class="rounded-sm bg-[#e8363c] px-4 py-2 text-lg text-white hover:bg-black"
                    >
                        Buy Now
                    </a>
                </div>
                {{-- Unsave --}}
                <livewire:save-lyric-button :lyric="$lyric" :key="$lyric->id" />
            </div>

            {{-- RIGHT COLUMN: Lyrics --}}
            <div class="rounded-lg bg-gray-100 p-4 w-full col-span-2">
                <pre class="whitespace-pre-wrap text-sm font-mono">{{ $lyric->content }}</pre>
            </div>

        </div>
    @empty
        <p>You haven't saved any lyrics yet.</p>
    @endforelse

    {{-- Pagination links --}}
    <div class="mt-8">
        {{ $favorites->links() }}
    </div>

</div>
