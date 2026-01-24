<x-layouts.page :title="__('Buy Pop Song Lyrics | Original Pop Lyrics for Sale - SongwriterLink')" 
:description="__('Browse original pop song lyrics written by independent lyricists. License professional pop lyrics for your next release — affordable, legal, and ready to use.')">
    
    <div class="flex flex-col px-6 text-[#1b1b18] lg:justify-between lg:px-8">
    
        <div class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
            <main
                class="flex w-full flex-col-reverse overflow-hidden rounded-lg lg:flex-row">
                <div class="p-6 lg:p-0 flex-1 rounded-lg pb-12 text-[13px] leading-[20px] bg-[#ffffff78] bg-gray-50 lg:p-20">
                    <h1 class="mb-1 font-medium text-4xl lg:text-6xl">Buy Pop Song Lyrics</h1>
                </div>  
            </main>
        </div>

        <div class="lg:w-2/3 lg:mx-20">         
            <h2 class="text-2xl mt-8 mb-4">Looking for pop song lyrics for your next release?</h2>
            <p>At SongwriterLink, you can browse and license original pop lyrics written by independent lyricists from around the world. Whether you’re an artist, 
                producer, or band, our pop lyrics are available for immediate use in your own music — no ghostwriters, no commissions, and no complicated contracts.</p>
            <h3 class="text-lg mt-8 mb-4"><b>How buying pop lyrics works</b></h3>
            <ol class="list-decimal ml-2 md:flex gap-4">
                <li class="bg-gray-200 mx-2 p-2">Browse available pop song lyrics below</li>
                <li class="bg-gray-100 mx-2 p-2">Preview the full lyrics before purchasing</li>
                <li class="bg-gray-200 mx-2 p-2">Choose a license that fits your project</li>
                <li class="bg-gray-100 mx-2 p-2">Download instantly and start recording</li>
            </ol>

            <p class="my-4">All lyrics on SongwriterLink are original works uploaded directly by the lyricists who wrote them.</p>

            <h3 class="text-lg mt-8 mb-4"><b>Are these pop lyrics safe to use?</b></h3>
            <p class="my-4">Yes. When you purchase lyrics on SongwriterLink, you receive a license from the original lyricist to 
                use those lyrics in your own song. This means you can legally record, release, and perform your song using the 
                purchased lyrics, according to the license terms chosen by the lyricist.</p>
            <p class="my-4">No guessing. No copyright risks. Just original pop lyrics ready for music.</p>

            <h3 class="text-lg mt-8 mb-4"><b>Why artists buy pop lyrics here</b></h3>
            <ol class="flex flex-col gap-2">
                <li class="bg-gray-100 p-2 w-fit"><i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Written by real songwriters, not AI</li>
                <li class="bg-gray-200 p-2 w-fit"><i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Perfect for pop, indie pop, dance-pop, and crossover styles</li>
                <li class="bg-gray-100 p-2 w-fit"><i class="fa-sharp-duotone fa-solid fa-badge-check"></i> More affordable than hiring a songwriter</li>
                <li class="bg-gray-200 p-2 w-fit"><i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Instant digital delivery</li>
                <li class="bg-gray-100 p-2 w-fit"><i class="fa-sharp-duotone fa-solid fa-badge-check"></i> Clear licensing terms with every purchase</li>
            </ol>

            <h3 class="mt-12 text-xl">Browse pop song lyrics for sale below and find the perfect lyrics for your next pop release.</h3>
        </div>

        <div class="gap-4 py-12 justify-around lg:grid grid-cols-3 gap-4 lg:mx-20">
            <!-- Loop through lyrics -->
            @if (count($lyrics)==0)
                Sorry, no lyrics were found. Please broaden your search.
            @else
                @foreach ($lyrics as $lyric)
                    <div class="p-4 border rounded mb-4">
                        <div x-text="lyric.title"></div>
                        <a
                            href="{{ route('lyrics.show', $lyric->slug) }}"
                            class="text-2xl font-semibold hover:underline"
                        >
                            {{ $lyric['title'] }}
                        </a>
                        <br />Written By:
                        <a
                            href="{{ route('users.show', $lyric->user) }}"
                            class="font-semibold hover:underline"
                        >
                            {{ $lyric['user']['name'] }}
                        </a>
                        <br /><span class="text-gray-400 text-sm mt-1">Posted: {{ $lyric->created_at->format('F j, Y') }}</span>

                        <pre class="whitespace-pre-wrap my-6 text-sm">{{ $lyric->snippet }}</pre>

                        <p class="my-2 text-gray-600">Genre: {{ $lyric['genre'] }}</p>
                        <p class="my-2 mb-6 font-bold">Price: ${{ $lyric['price'] }}</p>

                        <div class="xl:flex gap-2">
                            <div class="">
                                <button
                                    onclick="window.location.href='{{ route('lyrics.show', $lyric->slug) }}'"
                                    class="rounded-sm bg-[#e8363c] px-5 py-1 my-1 text-lg text-white hover:bg-black cursor-pointer"
                                >
                                    <i class="fa-sharp-duotone fa-solid fa-eye"></i> View Full Lyric
                                </button>
                            </div>
                            @if (auth()->id())
                                @if ($lyric->user_id !== auth()->id())
                                    <div class=""><livewire:save-lyric-button :lyric="$lyric" :key="$lyric->id" /></div>
                                @endif
                            @else
                                <div class="mt-4 xl:mt-0 pt-3"><a href="/login" class="pt-6"><span class="px-3 text-green-700">
                                    <i class="fa-sharp-duotone fa-regular fa-plus text-xl"></i> Log in to Save
                                </span></a></div>
                            @endif
                        </div>
                    </div>
                    @endforeach
            @endif

        </div>

        <div class="lg:w-2/3 lg:mx-20">
            <button
                onclick="window.location.href='{{ route('buyLyrics', $lyric->slug) }}'"
                class="rounded-sm bg-[#e8363c] px-5 py-1 my-1 text-lg text-white hover:bg-black cursor-pointer mx-auto w-fit"
            >
                <i class="fa-sharp-duotone fa-solid fa-eye"></i> View More Pop Lyrics
            </button>
            <hr class="mt-8" />
            <h3 class="text-lg mt-8 mb-4"><b>Can I release a song commercially using these lyrics?</b></h3>
            <p class="my-4">Yes. Each listing includes a license that allows you to use the lyrics in your own recorded music. Always check the specific license terms on the lyric page.</p>
            <h3 class="text-lg mt-8 mb-4"><b>Do I need to credit the lyricist?</b></h3>
            <p class="my-4">It's not a requirement but our lyricists appreciate it if you do.</p>
            <h3 class="text-lg mt-8 mb-4"><b>Can I modify the lyrics?</b></h3>
            <p class="my-4">Most lyricists allow minor edits. Contact the lyricist for details.</p>
            <h3 class="text-lg mt-8 mb-4"><b>Do I own the lyrics after purchase?</b></h3>
            <p class="my-4">You are purchasing a license to use the lyrics, not the copyright itself, unless explicitly stated.</p>
        </div> 

    </div>

</x-layouts.page>
