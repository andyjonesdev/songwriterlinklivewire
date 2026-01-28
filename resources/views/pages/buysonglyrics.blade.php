<x-layouts.page :title="__('Buy Song Lyrics | Original Lyrics for Sale - SongwriterLink')" 
:description="__('Browse original song lyrics written by independent lyricists. Buy licensed lyrics for recording, performance, and commercial music release.')">

<div class="flex flex-col px-6 text-[#1b1b18] lg:justify-between lg:px-8">

    <div class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
        <main class="flex w-full flex-col-reverse overflow-hidden rounded-lg lg:flex-row">
            <div class="p-6 lg:p-0 flex-1 rounded-lg pb-12 text-[13px] leading-[20px] bg-[#ffffff78] bg-gray-50 lg:p-20">
                <h1 class="mb-1 font-medium text-4xl lg:text-6xl">Buy Song Lyrics</h1>
            </div>  
        </main>
    </div>

    <div class="lg:w-2/3 lg:mx-20">
        <h2 class="text-2xl mt-8 mb-4">Purchase original lyrics for your next song</h2>

        <p>
            SongwriterLink is a lyric marketplace where independent lyricists sell original song lyrics to artists, 
            singers, and producers. Every lyric includes a license so you can legally record, perform, and release 
            your music using professionally written words.
        </p>

        <p class="my-4">
            Whether you’re creating pop, rock, hip-hop, country, jazz, or worship music, you can browse a wide range 
            of lyrics for sale and instantly download the perfect match for your melody and style.
        </p>

        <h3 class="text-lg mt-8 mb-4"><b>How buying song lyrics works</b></h3>
        <ol class="list-decimal ml-2 md:flex gap-4">
            <li class="bg-gray-200 mx-2 p-2">Browse available song lyrics by genre or mood</li>
            <li class="bg-gray-100 mx-2 p-2">Preview verses, choruses, and bridges</li>
            <li class="bg-gray-200 mx-2 p-2">Purchase with a one-time license fee</li>
            <li class="bg-gray-100 mx-2 p-2">Download instantly and start recording</li>
        </ol>

        <h3 class="text-lg mt-8 mb-4"><b>Who buys song lyrics?</b></h3>
        <p class="my-4">
            Artists, singers, music producers, YouTubers, podcasters, and filmmakers use SongwriterLink to find 
            high-quality lyrics without hiring a songwriter or writing from scratch.
        </p>

        <h3 class="text-lg mt-8 mb-4"><b>Why buy lyrics from SongwriterLink?</b></h3>
        <ol class="flex flex-col gap-2">
            <li class="bg-gray-100 p-2 w-fit">
                <i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Written by real lyricists
            </li>
            <li class="bg-gray-200 p-2 w-fit">
                <i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Clear licensing for commercial use
            </li>
            <li class="bg-gray-100 p-2 w-fit">
                <i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Works across all music genres
            </li>
            <li class="bg-gray-200 p-2 w-fit">
                <i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Instant digital delivery
            </li>
            <li class="bg-gray-100 p-2 w-fit">
                <i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Affordable alternative to hiring a songwriter
            </li>
        </ol>

    </div>

    <div class="lg:w-2/3 lg:mx-20 mt-4">
        <button onclick="window.location.href='{{ route('buyLyrics') }}'"
            class="rounded-sm bg-[#e8363c] px-5 py-1 my-1 text-lg text-white hover:bg-black cursor-pointer mx-auto w-fit">
            View More Lyrics
        </button>

        <hr class="mt-8" />

        <h3 class="text-lg mt-8 mb-4"><b>Can I release a song commercially?</b></h3>
        <p class="my-4">
            Yes. Each lyric includes a license allowing commercial release under the stated terms.
        </p>

        <h3 class="text-lg mt-8 mb-4"><b>Do I own the lyrics after purchase?</b></h3>
        <p class="my-4">
            You are purchasing a license to use the lyrics, not the copyright itself, unless otherwise stated.
        </p>

        <h3 class="text-lg mt-8 mb-4"><b>Can I edit the lyrics?</b></h3>
        <p class="my-4">
            Most lyricists allow minor edits. Always review the specific license terms.
        </p>
    </div>

</div>

</x-layouts.page>
