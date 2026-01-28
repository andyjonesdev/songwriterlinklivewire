<x-layouts.page :title="__('Lyric Marketplace | Buy & Sell Song Lyrics Online - SongwriterLink')" 
:description="__('SongwriterLink is a lyric marketplace where artists and lyricists buy and sell original song lyrics. Browse lyrics for all genres and license them instantly for your music projects.')">

<div class="flex flex-col px-6 text-[#1b1b18] lg:justify-between lg:px-8">

    <div class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
        <main class="flex w-full flex-col-reverse overflow-hidden rounded-lg lg:flex-row">
            <div class="p-6 lg:p-0 flex-1 rounded-lg pb-12 text-[13px] leading-[20px] bg-[#ffffff78] bg-gray-50 lg:p-20">
                <h1 class="mb-1 font-medium text-4xl lg:text-6xl">Lyric Marketplace</h1>
            </div>  
        </main>
    </div>

    <div class="lg:w-2/3 lg:mx-20">
        <h2 class="text-2xl mt-8 mb-4">A marketplace for buying and selling original song lyrics</h2>

        <p>
            SongwriterLink is an online lyric marketplace where independent lyricists publish their original song lyrics
            and artists, producers, and bands can browse and license them for real music projects. Instead of hiring a 
            songwriter or waiting for inspiration, you can explore ready-made lyrics across multiple genres and styles.
        </p>

        <p class="my-4">
            Every lyric on SongwriterLink is written by a real songwriter and uploaded directly to the platform. 
            Buyers can preview lyrics, choose a license, and download instantly after purchase.
        </p>

        <h3 class="text-lg mt-8 mb-4"><b>How the lyric marketplace works</b></h3>
        <ol class="list-decimal ml-2 md:flex gap-4">
            <li class="bg-gray-200 mx-2 p-2">Lyricists upload their original song lyrics</li>
            <li class="bg-gray-100 mx-2 p-2">Buyers browse lyrics by genre, mood, or theme</li>
            <li class="bg-gray-200 mx-2 p-2">Each lyric includes a license for legal use</li>
            <li class="bg-gray-100 mx-2 p-2">Download instantly and start recording</li>
        </ol>

        <h3 class="text-lg mt-8 mb-4"><b>What kind of lyrics can I find here?</b></h3>
        <p class="my-4">
            The SongwriterLink marketplace features lyrics for many musical styles, including pop, rap, rock, country, 
            jazz, R&amp;B, indie, metal, folk, Christian, soul, reggae, and more. Some lyrics are written for commercial 
            releases, while others are suited for demos, film projects, or independent albums.
        </p>

        <h3 class="text-lg mt-8 mb-4"><b>Are the lyrics safe to use commercially?</b></h3>
        <p class="my-4">
            Yes. When you purchase lyrics from the marketplace, you receive a license from the original lyricist that 
            allows you to use those lyrics in your own song. This means you can legally record, release, and perform your 
            music according to the license terms shown on each lyric page.
        </p>

        <h3 class="text-lg mt-8 mb-4"><b>Why artists use SongwriterLink</b></h3>
        <ol class="flex flex-col gap-2">
            <li class="bg-gray-100 p-2 w-fit">
                <i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Written by real lyricists, not AI
            </li>
            <li class="bg-gray-200 p-2 w-fit">
                <i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Cheaper than hiring a songwriter
            </li>
            <li class="bg-gray-100 p-2 w-fit">
                <i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Wide range of genres and moods
            </li>
            <li class="bg-gray-200 p-2 w-fit">
                <i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Instant digital delivery
            </li>
            <li class="bg-gray-100 p-2 w-fit">
                <i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Clear licensing with every purchase
            </li>
        </ol>

    </div>

    <div class="lg:w-2/3 lg:mx-20 mt-4">
        <button onclick="window.location.href='{{ route('buyLyrics') }}'"
            class="rounded-sm bg-[#e8363c] px-5 py-1 my-1 text-lg text-white hover:bg-black cursor-pointer mx-auto w-fit">
            Browse Lyrics
        </button>

        <hr class="mt-8" />

        <h3 class="text-lg mt-8 mb-4"><b>Who can use this lyric marketplace?</b></h3>
        <p class="my-4">
            This marketplace is used by singers, music producers, bands, independent artists, and content creators 
            looking for original lyrics to turn into finished songs.
        </p>

        <h3 class="text-lg mt-8 mb-4"><b>Do I own the lyrics after purchase?</b></h3>
        <p class="my-4">
            You are purchasing a license to use the lyrics, not the copyright itself, unless explicitly stated on the lyric page.
        </p>

        <h3 class="text-lg mt-8 mb-4"><b>Can I edit the lyrics?</b></h3>
        <p class="my-4">
            Most lyricists allow minor edits. Always check the individual license terms before making changes.
        </p>
    </div>

</div>

</x-layouts.page>
