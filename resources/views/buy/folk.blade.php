<x-layouts.page :title="__('Buy Folk Lyrics | Original Folk Song Lyrics - SongwriterLink')" 
:description="__('Explore original folk lyrics written by independent songwriters. Ideal for acoustic, storytelling, and indie folk music — ready to license and record.')"
:canonical="url()->current()">

<div class="flex flex-col px-6 text-[#1b1b18] lg:justify-between lg:px-8">

    <div class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
        <main class="flex w-full flex-col-reverse overflow-hidden rounded-lg lg:flex-row">
            <div class="p-6 lg:p-0 flex-1 rounded-lg pb-12 text-[13px] leading-[20px] bg-[#ffffff78] bg-gray-50 lg:p-20">
                <h1 class="mb-1 font-medium text-4xl lg:text-6xl">Buy Folk Lyrics</h1>
            </div>  
        </main>
    </div>

    <div class="lg:w-2/3 lg:mx-20">
        <h2 class="text-2xl mt-8 mb-4">Looking for authentic folk lyrics that tell a story?</h2>

        <p>
            Folk lyrics capture emotion, storytelling, and simplicity. SongwriterLink offers original lyrics written by independent folk songwriters, perfect for acoustic, indie, or singer-songwriter projects. Each lyric is crafted to fit melodies naturally while evoking imagery and narrative.
        </p>

        <h3 class="text-lg mt-8 mb-4"><b>How buying folk lyrics works</b></h3>
        <ol class="list-decimal ml-2 md:flex gap-4">
            <li class="bg-gray-200 mx-2 p-2">Browse lyrics by theme, story, or style</li>
            <li class="bg-gray-100 mx-2 p-2">Preview full verses and choruses</li>
            <li class="bg-gray-200 mx-2 p-2">Select a license for recording, streaming, or performance</li>
            <li class="bg-gray-100 mx-2 p-2">Download instantly and start recording</li>
        </ol>

        <p class="my-4">
            Every lyric is carefully written by songwriters passionate about storytelling through folk music.
        </p>

        <h3 class="text-lg mt-8 mb-4"><b>Why buy folk lyrics from SongwriterLink</b></h3>
        <ol class="flex flex-col gap-2">
            <li class="bg-gray-100 p-2 w-fit"><i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Written by experienced folk lyricists</li>
            <li class="bg-gray-200 p-2 w-fit"><i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Works for acoustic, indie folk, and storytelling songs</li>
            <li class="bg-gray-100 p-2 w-fit"><i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Affordable and instantly downloadable</li>
            <li class="bg-gray-200 p-2 w-fit"><i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Clear licensing for commercial or non-profit use</li>
            <li class="bg-gray-100 p-2 w-fit"><i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Lyrics designed to fit modern melodies and arrangements</li>
        </ol>

        <h3 class="mt-12 text-xl">Browse folk lyrics for sale below and find the perfect lyrics for your next folk recording.</h3>
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
                    <br /><span class="text-gray-400 text-sm mt-1">Posted: {{ $lyric->created_at->format('F j, Y') }}</span>
                    <pre class="whitespace-pre-wrap my-6 text-sm">{{ $lyric->snippet }}</pre>
                    <p class="my-2 text-gray-600">Genre: {{ $lyric['genre'] }}</p>
                    <p class="my-2 mb-6 font-bold">Price: ${{ $lyric['price'] }}</p>
                    <div class="xl:flex gap-2">
                        <button onclick="window.location.href='{{ route('lyrics.show', $lyric->slug) }}'" class="rounded-sm bg-[#e8363c] px-5 py-1 my-1 text-lg text-white hover:bg-black cursor-pointer">View Full Lyric</button>
                        @if (auth()->id())
                            @if ($lyric->user_id !== auth()->id())
                                <livewire:save-lyric-button :lyric="$lyric" :key="$lyric->id" />
                            @endif
                        @else
                            <a href="/login" class="pt-6"><span class="px-3 text-green-700">Log in to Save</span></a>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <div class="lg:w-2/3 lg:mx-20">
        <button onclick="window.location.href='{{ route('buyLyrics', 'genre=Folk') }}'" class="rounded-sm bg-[#e8363c] px-5 py-1 my-1 text-lg text-white hover:bg-black cursor-pointer mx-auto w-fit">View More Folk Lyrics</button>

        <hr class="mt-8" />
        <h3 class="text-lg mt-8 mb-4"><b>Can I release a song commercially using these lyrics?</b></h3>
        <p class="my-4">Yes. Each lyric includes a license allowing commercial release under the stated terms.</p>

        <h3 class="text-lg mt-8 mb-4"><b>Do I need to credit the lyricist?</b></h3>
        <p class="my-4">Credit is optional but appreciated.</p>

        <h3 class="text-lg mt-8 mb-4"><b>Can I modify the lyrics?</b></h3>
        <p class="my-4">Most lyricists allow minor edits; check license details.</p>

        <h3 class="text-lg mt-8 mb-4"><b>Do I own the lyrics after purchase?</b></h3>
        <p class="my-4">You are purchasing a license to use the lyrics, not the copyright itself.</p>
    </div>

</div>
</x-layouts.page>
