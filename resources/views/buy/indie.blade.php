<x-layouts.page :title="__('Buy Indie Song Lyrics | Original Indie Lyrics for Sale - SongwriterLink')" 
:description="__('Discover original indie song lyrics written by independent lyricists. License unique, story-driven indie lyrics for your next release — affordable, legal, and ready to record.')"
:canonical="url()->current()">
    
<div class="flex flex-col px-6 text-[#1b1b18] lg:justify-between lg:px-8">
    <nav class="text-sm text-gray-600 mb-4">
            <a href="/">Home</a> ›
            <a href="/buy-lyrics">Buy Lyrics</a> ›
            <span>
                Indie Lyrics
            </span>
        </nav>
    <div class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
        <main class="flex w-full flex-col-reverse overflow-hidden rounded-lg lg:flex-row">
            <div class="p-6 lg:p-0 flex-1 rounded-lg pb-12 text-[13px] leading-[20px] bg-[#ffffff78] bg-gray-50 lg:p-20">
                <h1 class="mb-1 font-medium text-4xl lg:text-6xl">Buy Indie Song Lyrics</h1>
            </div>  
        </main>
    </div>

    <div class="lg:w-2/3 lg:mx-20">         
        <h2 class="text-2xl mt-8 mb-4">Searching for indie lyrics with personality and meaning?</h2>

        <p>
            Indie music thrives on honesty, atmosphere, and storytelling. At SongwriterLink, you can explore original indie song lyrics written by independent lyricists who focus on emotion, imagery, and unique perspectives. Whether you’re creating indie pop, indie folk, or alternative indie tracks, you’ll find lyrics that feel personal and authentic.
        </p>

        <h3 class="text-lg mt-8 mb-4"><b>How buying indie lyrics works</b></h3>
        <ol class="list-decimal ml-2 md:flex gap-4">
            <li class="bg-gray-200 mx-2 p-2">Browse indie lyrics crafted for expressive songs</li>
            <li class="bg-gray-100 mx-2 p-2">Read full verses and choruses before purchasing</li>
            <li class="bg-gray-200 mx-2 p-2">Pick a license that suits your project</li>
            <li class="bg-gray-100 mx-2 p-2">Download instantly and begin recording</li>
        </ol>

        <p class="my-4">
            All lyrics listed on SongwriterLink are original works uploaded directly by the lyricists who wrote them.
        </p>

        <h3 class="text-lg mt-8 mb-4"><b>Are these indie lyrics safe to use?</b></h3>
        <p class="my-4">
            Yes. Each purchase includes a license from the original lyricist that grants you the right to use the lyrics in your own song. You can legally record, distribute, and perform your music according to the license terms provided with each listing.
        </p>

        <p class="my-4">
            No recycled phrases. No copyright uncertainty. Just original indie lyrics ready to become your song.
        </p>

        <h3 class="text-lg mt-8 mb-4"><b>Why artists choose indie lyrics here</b></h3>
        <ol class="flex flex-col gap-2">
            <li class="bg-gray-100 p-2 w-fit"><i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Written by independent songwriters, not AI tools</li>
            <li class="bg-gray-200 p-2 w-fit"><i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Designed for emotional and narrative-driven songs</li>
            <li class="bg-gray-100 p-2 w-fit"><i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Fits indie pop, folk, and alternative styles</li>
            <li class="bg-gray-200 p-2 w-fit"><i class="fa-sharp-duotone fa-solid fa-badge-check"></i> More affordable than hiring a private lyricist</li>
            <li class="bg-gray-100 p-2 w-fit"><i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Instant delivery with clear licensing terms</li>
        </ol>

        <h3 class="mt-12 text-xl">
            Browse indie song lyrics for sale below and discover the perfect lyrics for your next indie release.
        </h3>
    </div>

    <div class="gap-4 py-12 justify-around lg:grid grid-cols-3 lg:mx-20">
        @if (count($lyrics)==0)
            Sorry, no lyrics were found. Please broaden your search.
        @else
            @foreach ($lyrics as $lyric)
                <div class="p-4 border border-gray-200 rounded mb-4">
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
        <button onclick="window.location.href='{{ route('buyLyrics', 'genre=Indie') }}'"
            class="rounded-sm bg-[#e8363c] px-5 py-1 my-1 text-lg text-white hover:bg-black cursor-pointer mx-auto w-fit">
            View More Indie Lyrics
        </button>

        <hr class="mt-8" />

        <h3 class="text-lg mt-8 mb-4"><b>Can I release a song commercially using these lyrics?</b></h3>
        <p class="my-4">Yes. Each listing includes a license that allows commercial release under the stated terms.</p>

        <h3 class="text-lg mt-8 mb-4"><b>Do I need to credit the lyricist?</b></h3>
        <p class="my-4">Credit is optional, but many indie lyricists appreciate acknowledgment.</p>

        <h3 class="text-lg mt-8 mb-4"><b>Can I adapt the lyrics to my own style?</b></h3>
        <p class="my-4">Most lyricists allow minor edits. Always check the individual license details.</p>

        <h3 class="text-lg mt-8 mb-4"><b>Do I own the lyrics after purchase?</b></h3>
        <p class="my-4">You are purchasing a license to use the lyrics, not the copyright itself, unless explicitly stated.</p>
    </div>
        
        <p class="mt-8 text-lg flex gap-2 flex-wrap lg:mx-20">
            Browse more:
            <a href="/buy-folk-lyrics" class="text-red-600 underline bg-gray-200 px-2">Folk Lyrics</a>
            <a href="/buy-country-lyrics" class="text-red-600 underline bg-gray-200 px-2">Country Lyrics</a>
            <a href="/buy-rock-lyrics" class="text-red-600 underline bg-gray-200 px-2">Rock Lyrics</a>
            <a href="/buy-christian-lyrics" class="text-red-600 underline bg-gray-200 px-2">Christian Lyrics</a>
            <a href="/buy-lyrics" class="text-red-600 underline bg-gray-200 px-2">Buy Lyrics</a>
            <a href="/lyric-marketplace" class="text-red-600 underline bg-gray-200 px-2">Lyric Marketplace</a>
        </p>
</div>

</x-layouts.page>
