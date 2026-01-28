<x-layouts.page :title="__('Royalty-Free Lyrics | Buy Song Lyrics Without Copyright Issues - SongwriterLink')" 
:description="__('Browse royalty-free lyrics written by independent lyricists. License original song lyrics for commercial use with clear terms and no copyright confusion.')">

<div class="flex flex-col px-6 text-[#1b1b18] lg:justify-between lg:px-8">

    <div class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
        <main class="flex w-full flex-col-reverse overflow-hidden rounded-lg lg:flex-row">
            <div class="p-6 lg:p-0 flex-1 rounded-lg pb-12 text-[13px] leading-[20px] bg-[#ffffff78] bg-gray-50 lg:p-20">
                <h1 class="mb-1 font-medium text-4xl lg:text-6xl">Royalty-Free Lyrics</h1>
            </div>  
        </main>
    </div>

    <div class="lg:w-2/3 lg:mx-20">
        <h2 class="text-2xl mt-8 mb-4">Buy royalty-free lyrics for your music projects</h2>

        <p>
            SongwriterLink offers royalty-free lyrics written by independent lyricists and licensed for use in your own 
            songs. This means you can record, release, and perform your music using purchased lyrics without worrying 
            about hidden fees, future royalties, or copyright confusion.
        </p>

        <p class="my-4">
            Each lyric listing clearly displays its license terms so you know exactly how the lyrics can be used before 
            purchasing. Whether you're releasing a single, album, or soundtrack, royalty-free lyrics make it easy to 
            focus on your music instead of paperwork.
        </p>

        <h3 class="text-lg mt-8 mb-4"><b>What does “royalty-free lyrics” mean?</b></h3>
        <p class="my-4">
            Royalty-free lyrics means you pay once for a license and can then use the lyrics according to the stated terms 
            without paying ongoing royalties to the lyricist. The lyricist remains the copyright holder unless otherwise 
            stated, but grants you legal permission to use the lyrics in your own recordings and performances.
        </p>

        <h3 class="text-lg mt-8 mb-4"><b>How royalty-free lyrics work</b></h3>
        <ol class="list-decimal ml-2 md:flex gap-4">
            <li class="bg-gray-200 mx-2 p-2">Browse available royalty-free lyrics</li>
            <li class="bg-gray-100 mx-2 p-2">Read the license terms on each lyric page</li>
            <li class="bg-gray-200 mx-2 p-2">Purchase the lyric with a one-time fee</li>
            <li class="bg-gray-100 mx-2 p-2">Download instantly and start recording</li>
        </ol>

        <h3 class="text-lg mt-8 mb-4"><b>Who uses royalty-free lyrics?</b></h3>
        <p class="my-4">
            Royalty-free lyrics are used by independent artists, singers, music producers, YouTubers, podcasters, and 
            filmmakers who need original lyrics for commercial or personal projects without long-term licensing 
            obligations.
        </p>

        <h3 class="text-lg mt-8 mb-4"><b>Why buy royalty-free lyrics from SongwriterLink?</b></h3>
        <ol class="flex flex-col gap-2">
            <li class="bg-gray-100 p-2 w-fit">
                <i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Written by real lyricists, not AI
            </li>
            <li class="bg-gray-200 p-2 w-fit">
                <i class="fa-sharp-duotone fa-solid fa-badge-check"></i> One-time purchase with clear license terms
            </li>
            <li class="bg-gray-100 p-2 w-fit">
                <i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Safe for commercial release
            </li>
            <li class="bg-gray-200 p-2 w-fit">
                <i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Instant digital delivery
            </li>
            <li class="bg-gray-100 p-2 w-fit">
                <i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Affordable compared to hiring a songwriter
            </li>
        </ol>

    </div>

    <div class="lg:w-2/3 lg:mx-20 mt-4">
        <button onclick="window.location.href='{{ route('buyLyrics') }}'"
            class="rounded-sm bg-[#e8363c] px-5 py-1 my-1 text-lg text-white hover:bg-black cursor-pointer mx-auto w-fit">
            View All Lyrics
        </button>

        <hr class="mt-8" />

        <h3 class="text-lg mt-8 mb-4"><b>Can I use royalty-free lyrics commercially?</b></h3>
        <p class="my-4">
            Yes. Each lyric listing includes a license that allows commercial use under the stated terms. Always review 
            the specific license details before release.
        </p>

        <h3 class="text-lg mt-8 mb-4"><b>Do I own the copyright?</b></h3>
        <p class="my-4">
            You are purchasing a license to use the lyrics, not the copyright itself, unless explicitly stated on the lyric page.
        </p>

        <h3 class="text-lg mt-8 mb-4"><b>Can I modify the lyrics?</b></h3>
        <p class="my-4">
            Most lyricists allow minor edits. Check each lyric’s license terms for permissions.
        </p>
    </div>

</div>

</x-layouts.page>
