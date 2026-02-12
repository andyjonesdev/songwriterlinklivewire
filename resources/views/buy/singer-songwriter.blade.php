<x-layouts.page :title="__('Buy Singer-Songwriter Lyrics | Original Acoustic Lyrics for Sale - SongwriterLink')" 
:description="__('Browse original singer-songwriter lyrics written by independent lyricists. License heartfelt, story-driven lyrics for acoustic and stripped-down music — affordable, legal, and ready to record.')"
:canonical="url()->current()">
    
<div class="flex flex-col px-6 text-[#1b1b18] lg:justify-between lg:px-8">
    <nav class="text-sm text-gray-600 mb-4">
            <a href="/">Home</a> ›
            <a href="/buy-lyrics">Buy Lyrics</a> ›
            <span>
                Singer-Songwriter Lyrics
            </span>
        </nav>
    <div class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
        <main class="flex w-full flex-col-reverse overflow-hidden rounded-lg lg:flex-row">
            <div class="p-6 lg:p-0 flex-1 rounded-lg pb-12 text-[13px] leading-[20px] bg-[#ffffff78] bg-gray-50 lg:p-20">
                <h1 class="mb-1 font-medium text-4xl lg:text-6xl">Buy Singer-Songwriter Lyrics</h1>
            </div>  
        </main>
    </div>

    <div class="lg:w-2/3 lg:mx-20">         
        <h2 class="text-2xl mt-8 mb-4">Looking for emotional, story-driven lyrics?</h2>

        <p>
            Singer-songwriter music is rooted in honesty, simplicity, and personal storytelling. At SongwriterLink, you can explore original singer-songwriter lyrics written by independent lyricists who focus on meaningful narratives, introspective themes, and acoustic-friendly song structures. Whether you’re recording a stripped-down guitar track or a piano-based ballad, you’ll find lyrics designed to connect with listeners on a deeper level.
        </p>

        <h3 class="text-lg mt-8 mb-4"><b>How buying singer-songwriter lyrics works</b></h3>
        <ol class="list-decimal ml-2 md:flex gap-4">
            <li class="bg-gray-200 mx-2 p-2">Browse lyrics written for acoustic and narrative-driven songs</li>
            <li class="bg-gray-100 mx-2 p-2">Preview complete verses and choruses before purchasing</li>
            <li class="bg-gray-200 mx-2 p-2">Select a license that fits your release plans</li>
            <li class="bg-gray-100 mx-2 p-2">Download instantly and start recording</li>
        </ol>

        <p class="my-4">
            All lyrics on SongwriterLink are original works uploaded directly by the lyricists who wrote them.
        </p>

        <h3 class="text-lg mt-8 mb-4"><b>Are these singer-songwriter lyrics safe to use?</b></h3>
        <p class="my-4">
            Yes. Each purchase includes a license from the original lyricist allowing you to record, release, and perform your song using their lyrics, based on the terms provided with each listing.
        </p>

        <p class="my-4">
            No mass-produced templates. No copyright uncertainty. Just original lyrics written for real music.
        </p>

        <h3 class="text-lg mt-8 mb-4"><b>Why artists buy singer-songwriter lyrics here</b></h3>
        <ol class="flex flex-col gap-2">
            <li class="bg-gray-100 p-2 w-fit"><i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Written by real singer-songwriter lyricists</li>
            <li class="bg-gray-200 p-2 w-fit"><i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Designed for acoustic guitar and piano songs</li>
            <li class="bg-gray-100 p-2 w-fit"><i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Ideal for folk, indie-folk, and acoustic pop styles</li>
            <li class="bg-gray-200 p-2 w-fit"><i class="fa-sharp-duotone fa-solid fa-badge-check"></i> More affordable than hiring a full-time songwriter</li>
            <li class="bg-gray-100 p-2 w-fit"><i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Instant digital licensing and delivery</li>
        </ol>

        <h3 class="mt-12 text-xl">
            Browse singer-songwriter lyrics for sale below and find the perfect words for your next song.
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
        <button onclick="window.location.href='{{ route('buyLyrics', 'genre=Singer-Songwriter') }}'"
            class="rounded-sm bg-[#e8363c] px-5 py-1 my-1 text-lg text-white hover:bg-black cursor-pointer mx-auto w-fit">
            View More Singer-Songwriter Lyrics
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
        
        <p class="mt-8 text-lg flex gap-2 flex-wrap lg:mx-20">
            Browse more:
            <a href="/buy-pop-lyrics" class="text-red-600 underline bg-gray-200 px-2">Pop Lyrics</a>
            <a href="/buy-randb-lyrics" class="text-red-600 underline bg-gray-200 px-2">R&B Lyrics</a>
            <a href="/buy-rock-lyrics" class="text-red-600 underline bg-gray-200 px-2">Rock Lyrics</a>
            <a href="/buy-soul-lyrics" class="text-red-600 underline bg-gray-200 px-2">Soul Lyrics</a>
            <a href="/buy-lyrics" class="text-red-600 underline bg-gray-200 px-2">Buy Lyrics</a>
            <a href="/lyric-marketplace" class="text-red-600 underline bg-gray-200 px-2">Lyric Marketplace</a>
        </p>

</div>

</x-layouts.page>
