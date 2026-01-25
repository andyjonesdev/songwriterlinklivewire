<x-layouts.page :title="__('Buy Jazz Lyrics | Original Jazz Lyrics for Sale - SongwriterLink')" 
:description="__('Explore original jazz lyrics written by independent lyricists. License sophisticated, lyrical lyrics for jazz standards, ballads, and swing — ready for recording and performance.')"
:canonical="url()->current()">

<div class="flex flex-col px-6 text-[#1b1b18] lg:justify-between lg:px-8">

    <div class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
        <main class="flex w-full flex-col-reverse overflow-hidden rounded-lg lg:flex-row">
            <div class="p-6 lg:p-0 flex-1 rounded-lg pb-12 text-[13px] leading-[20px] bg-[#ffffff78] bg-gray-50 lg:p-20">
                <h1 class="mb-1 font-medium text-4xl lg:text-6xl">Buy Jazz Lyrics</h1>
            </div>  
        </main>
    </div>

    <div class="lg:w-2/3 lg:mx-20">
        <h2 class="text-2xl mt-8 mb-4">Looking for smooth, sophisticated jazz lyrics?</h2>

        <p>
            Jazz lyrics are all about mood, rhythm, and storytelling with flair. At SongwriterLink, you can browse original jazz lyrics written by independent lyricists who specialize in swing, ballads, standards, and improvisational styles. Perfect for singers, instrumentalists, or bands looking to add lyrical depth to their jazz compositions.
        </p>

        <h3 class="text-lg mt-8 mb-4"><b>How buying jazz lyrics works</b></h3>
        <ol class="list-decimal ml-2 md:flex gap-4">
            <li class="bg-gray-200 mx-2 p-2">Browse original jazz lyrics curated for voice and phrasing</li>
            <li class="bg-gray-100 mx-2 p-2">Preview full verses, choruses, and bridges</li>
            <li class="bg-gray-200 mx-2 p-2">Choose a license that fits your performance or recording needs</li>
            <li class="bg-gray-100 mx-2 p-2">Download instantly and start recording</li>
        </ol>

        <p class="my-4">
            All lyrics are handcrafted by lyricists passionate about jazz music and its nuances.
        </p>

        <h3 class="text-lg mt-8 mb-4"><b>Are these jazz lyrics safe to use?</b></h3>
        <p class="my-4">
            Yes. Each purchase includes a license from the original lyricist allowing you to record, release, and perform the song legally, according to the license terms.
        </p>

        <h3 class="text-lg mt-8 mb-4"><b>Why artists choose jazz lyrics from SongwriterLink</b></h3>
        <ol class="flex flex-col gap-2">
            <li class="bg-gray-100 p-2 w-fit"><i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Written by real jazz lyricists, not AI</li>
            <li class="bg-gray-200 p-2 w-fit"><i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Works with swing, bebop, ballads, and smooth jazz</li>
            <li class="bg-gray-100 p-2 w-fit"><i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Crafted for vocal phrasing and improvisation</li>
            <li class="bg-gray-200 p-2 w-fit"><i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Affordable and ready for instant digital delivery</li>
            <li class="bg-gray-100 p-2 w-fit"><i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Clear licensing terms included with every lyric</li>
        </ol>

        <h3 class="mt-12 text-xl">Browse jazz lyrics for sale below and find the perfect lyrics for your next jazz recording.</h3>
    </div>

    <div class="gap-4 py-12 justify-around lg:grid grid-cols-3 lg:mx-20">
        @if (count($lyrics) == 0)
            Sorry, no lyrics were found. Please broaden your search.
        @else
            @foreach ($lyrics as $lyric)
                <div class="p-4 border rounded mb-4">
                    <a href="{{ route('lyrics.show', $lyric->slug) }}" class="text-2xl font-semibold hover:underline">
                        {{ $lyric['title'] }}
                    </a>

                    <br />Written By:
                    <a href="{{ route('users.show', $lyric->user) }}" class="font-semibold hover:underline">
                        {{ $lyric['user']['name'] }}
                    </a>

                    <br /><span class="text-gray-400 text-sm mt-1">
                        Posted: {{ $lyric->created_at->format('F j, Y') }}
                    </span>

                    <pre class="whitespace-pre-wrap my-6 text-sm">{{ $lyric->snippet }}</pre>

                    <p class="my-2 text-gray-600">Genre: {{ $lyric['genre'] }}</p>
                    <p class="my-2 mb-6 font-bold">Price: ${{ $lyric['price'] }}</p>

                    <div class="xl:flex gap-2">
                        <button onclick="window.location.href='{{ route('lyrics.show', $lyric->slug) }}'"
                            class="rounded-sm bg-[#e8363c] px-5 py-1 my-1 text-lg text-white hover:bg-black cursor-pointer">
                            View Full Lyric
                        </button>

                        @if (auth()->id())
                            @if ($lyric->user_id !== auth()->id())
                                <livewire:save-lyric-button :lyric="$lyric" :key="$lyric->id" />
                            @endif
                        @else
                            <a href="/login" class="pt-6">
                                <span class="px-3 text-green-700">Log in to Save</span>
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <div class="lg:w-2/3 lg:mx-20">
        <button onclick="window.location.href='{{ route('buyLyrics', 'genre=Jazz') }}'"
            class="rounded-sm bg-[#e8363c] px-5 py-1 my-1 text-lg text-white hover:bg-black cursor-pointer mx-auto w-fit">
            View More Jazz Lyrics
        </button>

        <hr class="mt-8" />

        <h3 class="text-lg mt-8 mb-4"><b>Can I release a song commercially using these lyrics?</b></h3>
        <p class="my-4">Yes. Each lyric includes a license allowing commercial release under the stated terms.</p>

        <h3 class="text-lg mt-8 mb-4"><b>Do I need to credit the lyricist?</b></h3>
        <p class="my-4">Credit is optional, but many lyricists appreciate acknowledgment.</p>

        <h3 class="text-lg mt-8 mb-4"><b>Can I adapt the lyrics to fit my melody?</b></h3>
        <p class="my-4">Most lyricists allow light edits. Check the specific license terms for details.</p>

        <h3 class="text-lg mt-8 mb-4"><b>Do I own the lyrics after purchase?</b></h3>
        <p class="my-4">You are purchasing a license to use the lyrics, not the copyright itself, unless explicitly stated.</p>
    </div>

</div>

</x-layouts.page>
