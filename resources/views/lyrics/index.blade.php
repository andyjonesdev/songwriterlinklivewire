<x-layouts.app :title="__('Your Lyrics')">

    <h1 class="text-3xl mb-4">Your Lyrics</h1>
    <p class="my-8"><a href="/lyrics/create" class="rounded-sm bg-[#e8363c] px-5 py-2 text-lg leading-normal text-white hover:border-black 
    hover:bg-black dark:border-[#e8363c] dark:bg-[#e8363c] dark:text-[#1C1C1A] 
    dark:hover:border-white dark:hover:bg-white">Upload New Lyric</a></p>

    @foreach ($lyrics as $lyric)
        <div class="pt-4 pb-8 lg:grid grid-cols-2 gap-8 my-8 border-b border-gray-100">

            <div class="lg:pr-8 lg:border-r lg:border-gray-100">
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

                <div class="flex gap-2 my-4">
                    <a
                        href="{{ route('lyrics.show', $lyric) }}"
                        class="bg-blue-900 text-white px-2 py-1 rounded-md text-center"
                    >
                        <i class="fa-sharp-duotone fa-solid fa-eye"></i> View
                    </a>

                    <a
                        href="{{ route('lyrics.edit', $lyric) }}"
                        class="bg-red-700 text-white px-2 py-1 rounded-md text-center"
                    >
                        <i class="fa-sharp-duotone fa-solid fa-pen-to-square"></i> Edit
                    </a>

                    <a
                        href="{{ route('lyrics.promote', $lyric) }}"
                        class="bg-yellow-500 text-white px-2 py-1 rounded-md text-center"
                    >
                        <i class="fa-sharp-duotone fa-solid fa-up"></i> Promote
                    </a>

                    <a
                        href="https://copyrightsolved.com" target="_blank"
                        class="bg-green-700 text-white px-2 py-1 rounded-md text-center"
                    >
                        <i class="fa-sharp-duotone fa-solid fa-file-lock"></i> Protect
                    </a>
                    
                    <form
                        method="POST"
                        action="{{ route('lyrics.destroy', $lyric) }}"
                        onsubmit="return confirm('Delete this lyric?')"
                    >
                        @csrf
                        @method('DELETE')

                        <button class="bg-gray-500 text-white px-2 py-1 rounded-md cursor-pointer text-center">
                            <i class="fa-sharp-duotone fa-solid fa-xmark"></i> Delete
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
