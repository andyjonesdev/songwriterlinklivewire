<x-layouts.page :title="__('Songwriter Link: Buy and Sell Original Song Lyrics')" :description="__('Discover Fresh, Original Song Lyrics for Your Next Music Project. Browse the world’s leading catalogue of high-quality lyrics, crafted by professional songwriters.')">
  
        <div
            class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0"
        >
            <main
                class="flex w-full flex-col-reverse overflow-hidden lg:flex-row"
                style="background-image: url('/storage/hero_bg.jpg'); background-size: cover;"
            >
                <div
                    class="flex-1 pb-12 text-[13px] leading-[20px] bg-[#ffffff78] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] p-8 lg:p-20"
                >
                    <h1 class="mb-1 font-medium text-6xl">Notice to all songwriters</h1>
                    <h2 class="text-3xl my-4">Lyrics and users under review</h2>
                    <div class="text-lg">
                        <p class="my-2">SongwriterLink was setup originally to help songwriters and lyricists sell their lyrics in a simple and 
                        affordable manner. We only accept original lyrics written by the person uploading them. However, we have recently found out 
                        that many of the lyric submissions uploaded have been copied directly and illegally from another web platform. Therefore, 
                        SongwriterLink is currently unavailable whilst we do a thorough internal review.</p>
                        <p class="my-2">
                        We take matters of copyright infringement very seriously and we will ban and report any users trying to pass other people's work as their own.
                        </p>
                    </div>
                </div>
                <div
                    class="hidden lg:block relative -mb-px aspect-335/376 w-full shrink-0 overflow-hidden rounded-t-lg bg-[#fff2f270] lg:mb-0 lg:-ml-px lg:aspect-auto lg:w-[438px] lg:rounded-t-none lg:rounded-r-lg"
                >
                    
                    
                    <div
                        class="hidden lg:block absolute inset-0 rounded-t-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] lg:overflow-hidden lg:rounded-t-none lg:rounded-r-lg"
                    />
                </div>
            </main>
        </div>

        <div class="bg-gray-900 text-white lg:grid grid-cols-3 gap-4 p-12 text-center justify-between">
            <div class="p-4">
                <i class="fa-solid fa-shield-halved text-4xl"></i>
                <h3 class="text-3xl mt-4 my-2">Fully Secure</h3>
                <p>100% Secure Payment</p>
            </div>
            <div class="p-4">
                <i class="fa-solid fa-handshake-angle text-4xl"></i>
                <h3 class="text-3xl mt-4 my-2">24/7 Support​</h3>
                <p>Dedicated support</p>
            </div><div class="p-4">
                <i class="fa-solid fa-hand-holding-circle-dollar text-4xl"></i>
                <h3 class="text-3xl mt-4 my-2">Sell your lyrics & poems​</h3>
                <p>Set your own prices</p>
            </div>
        </div>



        <!-- <div class="md:grid grid-cols-2 gap-12 p-4 lg:mt-12">
            <div>
                <div class="p-12">
                    <h2 class="text-4xl font-bold mb-8">Calling all songwriters!</h2>
                    <h4 class="text-xl my-2">Are you looking for music collaborators? Verse-Chorus is the place to find lyricists, musicians, singers, producers and composers.</h4>
                    <p class="my-4"><img src="/storage/verse-chorus-logo-2024-small.png" alt="Verse-Chorus logo" /></p>
  
                    <a
                        href="https://www.verse-chorus.com/" tartget="_blank"
                        class="
                        rounded-sm bg-[#e8363c] mt-4 px-5 py-2 my-4 text-lg leading-normal text-white hover:border-black hover:bg-black"
                    >
                        Visit Verse-Chorus
                    </a>
                </div>
            </div>
            <div>
                <img src="/storage/guitarist.jpg" alt="A person writing lyrics" />
            </div>
        </div> -->

        <!-- <div class="p-4 lg:mt-12 text-center">

                <div class="md:p-12">
                    <h2 class="text-4xl font-bold mb-8"><i class="fa-solid fa-trophy-star"></i> SL Lyric Writing Contest!</h2>
                    <h4 class="text-xl my-2">The first Songwriter Link lyric writing contest is now open!</h4>
                    <h4 class="text-xl my-2">Full details can be found on our 
                        <a href="https://greatbritishlyriccontest.com/" target="_blank"><u>dedicated contest website</u></a>.</h4>
                    <h3 class="my-4 text-2xl font-bold"><b>The current prize pot is £800</b>.</h3>
                    <p class="my-2">The contest runs from February 20th 2026 until April 30th 2026.</p>
					<p class="mt-2 mb-6">Winners announced May 2026.</p>
                    <a
                        href="https://greatbritishlyriccontest.com/" tartget="_blank"
                        class="
                        rounded-sm bg-[#e8363c] mt-4 px-5 py-2 my-4 text-lg leading-normal text-white hover:border-black hover:bg-black"
                    >
                        Enter your lyric now
                    </a>
                </div>
        </div> -->

        <h3 class="text-4xl mt-12 font-bold text-center">Latest Songwriting Articles​</h3>

        <div class="gap-4 p-6 lg:px-12 py-12 text-left justify-around lg:grid grid-cols-3 gap-4">
    
            @foreach ($blogs as $blog)
                <div class="p-4 border border-gray-200 rounded mb-4">
                    <a
                        href="{{ route('blog.show', $blog->slug) }}"
                        class="text-2xl font-semibold hover:underline"
                    >
                        {{ $blog['title'] }}
                    </a>
                    
                    <p class="text-gray-600 mt-2">
                        {{ $blog['snippet'] }}
                    </p>

                    <p class="my-4 text-gray-600">Category: {{ $blog['category'] }}</p>
                    <a
                        href="{{ route('blog.show', $blog->slug) }}"
                        class="
                        rounded-sm bg-[#e8363c] px-5 py-2 my-4 text-lg leading-normal text-white hover:border-black hover:bg-black"
                    >
                        View Article
                    </a>
            </div>
            @endforeach

        </div>

</x-layouts.page>
