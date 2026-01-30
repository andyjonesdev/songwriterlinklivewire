<x-layouts.page :title="__('Buy Rock Song Lyrics | Original Rock Lyrics for Sale - SongwriterLink')" 
:description="__('Browse original rock song lyrics written by independent songwriters. License powerful, performance-ready rock lyrics for your next release — affordable, legal, and ready to record.')"
:canonical="url()->current()">
    
<div class="flex flex-col px-6 text-[#1b1b18] lg:justify-between lg:px-8">
    <nav class="text-sm text-gray-600 mb-4">
            <a href="/">Home</a> ›
            <a href="/buy-lyrics">Buy Lyrics</a> ›
            <span>
                Rock Lyrics
            </span>
        </nav>
    <div class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
        <main class="flex w-full flex-col-reverse overflow-hidden rounded-lg lg:flex-row">
            <div class="p-6 lg:p-0 flex-1 rounded-lg pb-12 text-[13px] leading-[20px] bg-[#ffffff78] bg-gray-50 lg:p-20">
                <h1 class="mb-1 font-medium text-4xl lg:text-6xl">Buy Rock Song Lyrics</h1>
            </div>  
        </main>
    </div>

    <div class="lg:w-2/3 lg:mx-20">         
        <h2 class="text-2xl mt-8 mb-4">Looking for rock lyrics with attitude and impact?</h2>

        <p>
            Rock music is driven by energy, emotion, and unforgettable hooks. At SongwriterLink, you can browse original rock song lyrics written by independent lyricists who understand how to write for bands, singers, and guitar-driven tracks. Whether you’re recording alternative rock, classic rock, indie rock, or modern rock, you’ll find lyrics designed to work on stage and in the studio.
        </p>

        <h3 class="text-lg mt-8 mb-4"><b>How buying rock lyrics works</b></h3>
        <ol class="list-decimal ml-2 md:flex gap-4">
            <li class="bg-gray-200 mx-2 p-2">Browse rock lyrics written for vocal-driven songs</li>
            <li class="bg-gray-100 mx-2 p-2">Preview full verses and choruses before purchase</li>
            <li class="bg-gray-200 mx-2 p-2">Select a license that fits your band or solo project</li>
            <li class="bg-gray-100 mx-2 p-2">Download instantly and start rehearsing or recording</li>
        </ol>

        <p class="my-4">
            Every lyric on SongwriterLink is an original work uploaded directly by the songwriter who created it.
        </p>

        <h3 class="text-lg mt-8 mb-4"><b>Are these rock lyrics safe to use?</b></h3>
        <p class="my-4">
            Yes. When you purchase rock lyrics on SongwriterLink, you receive a license from the original lyricist that allows you to use the words in your own recorded music. You can legally release, perform live, and distribute your song according to the license terms provided.
        </p>

        <p class="my-4">
            No recycled lines. No copyright confusion. Just original rock lyrics ready for your music.
        </p>

        <h3 class="text-lg mt-8 mb-4"><b>Why artists buy rock lyrics here</b></h3>
        <ol class="flex flex-col gap-2">
            <li class="bg-gray-100 p-2 w-fit"><i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Written by real songwriters, not AI generators</li>
            <li class="bg-gray-200 p-2 w-fit"><i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Built for bands, singers, and guitar-based music</li>
            <li class="bg-gray-100 p-2 w-fit"><i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Works for alternative, indie, classic, and modern rock</li>
            <li class="bg-gray-200 p-2 w-fit"><i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Cheaper than hiring a private songwriter</li>
            <li class="bg-gray-100 p-2 w-fit"><i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Instant digital delivery with clear licensing</li>
        </ol>

        <h3 class="mt-12 text-xl">
            Browse rock song lyrics for sale below and find the perfect words for your next rock release.
        </h3>
    </div>

    <div class="gap-4 py-12 justify-around lg:grid grid-cols-3 lg:mx-20">
        @if (count($lyrics)==0)
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
        <button onclick="window.location.href='{{ route('buyLyrics', 'genre=Rock') }}'"
            class="rounded-sm bg-[#e8363c] px-5 py-1 my-1 text-lg text-white hover:bg-black cursor-pointer mx-auto w-fit">
            View More Rock Lyrics
        </button>

        <hr class="mt-8" />

        <h3 class="text-lg mt-8 mb-4"><b>Can I release a rock song commercially using these lyrics?</b></h3>
        <p class="my-4">Yes. Each lyric listing includes a license that allows you to record and release your song.</p>

        <h3 class="text-lg mt-8 mb-4"><b>Do I need to credit the songwriter?</b></h3>
        <p class="my-4">Credit is optional, but many rock lyricists appreciate being acknowledged.</p>

        <h3 class="text-lg mt-8 mb-4"><b>Can I change the lyrics to fit my band’s style?</b></h3>
        <p class="my-4">Most lyricists allow light edits. Always check the license details on the lyric page.</p>

        <h3 class="text-lg mt-8 mb-4"><b>Do I own the lyrics after purchase?</b></h3>
        <p class="my-4">You are purchasing a license to use the lyrics, not the copyright itself, unless stated otherwise.</p>
    </div>

</div>

</x-layouts.page>
