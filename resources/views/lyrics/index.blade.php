<x-layouts.app :title="__('Your Lyrics')">

    <h1 class="text-3xl mb-4">Your Lyrics</h1>
    <p class="my-8"><a href="/lyrics/create" class="rounded-sm bg-[#e8363c] px-5 py-2 text-lg leading-normal text-white hover:border-black 
    hover:bg-black dark:border-[#e8363c] dark:bg-[#e8363c] dark:text-[#1C1C1A] 
    dark:hover:border-white dark:hover:bg-white">Upload New Lyric</a></p>

    @foreach ($lyrics as $lyric)
        <div class="pt-4 pb-8 lg:grid grid-cols-3 gap-8 my-8 border-b border-gray-100">

            <div class="lg:col-span-2 lg:pr-8 lg:border-r lg:border-gray-100">
                <h2 class="font-semibold text-lg">{{ $lyric->title }}</h2>
                <p class="mt-2 whitespace-pre-line">{{ $lyric->snippet }}</p>
            </div>

            <div>
                <p class="text-gray-600">
                    Genre: <b>{{ $lyric->genre }}</b>
                </p>

                <p class="mt-2">
                    Price: <b>${{ $lyric->price }}</b>
                </p>

                <div class="flex gap-4 my-4">
                    <a
                        href="{{ route('lyrics.show', $lyric) }}"
                        class="bg-red-900 text-white px-2 py-1 rounded-md"
                    >
                        View
                    </a>

                    <a
                        href="{{ route('lyrics.edit', $lyric) }}"
                        class="bg-red-700 text-white px-2 py-1 rounded-md"
                    >
                        Edit
                    </a>

                    <!-- <a
                        href="{{ route('lyrics.promote', $lyric) }}"
                        class="bg-red-500 text-white px-2 py-1 rounded-md"
                    >
                        Promote
                    </a> -->
                    
                    <form
                        method="POST"
                        action="{{ route('lyrics.destroy', $lyric) }}"
                        onsubmit="return confirm('Delete this lyric?')"
                    >
                        @csrf
                        @method('DELETE')

                        <button class="bg-gray-500 text-white px-2 py-1 rounded-md cursor-pointer">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $lyrics->links() }}
    </div>

</x-layouts.app>
