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
                    <h1 class="mb-1 font-medium text-6xl">Buy lyrics online</h1>
                    <h2 class="text-3xl my-4">Sell lyrics and poems online</h2>
                    <div class="text-lg">
                        <p class="my-2">A place where you can sell your lyrics to songwriters who need your help to finish their songs.</p>
                        <p class="my-2">Buy and Sell Original Lyrics, Songs, and Poems at SongwriterLink – The Global Marketplace for Creative Writers and Musicians.</p>
                        <p class="my-2">SongwriterLink is the world’s leading online marketplace for buying and selling original lyrics and poetry. Whether you’re a songwriter, music producer, performing artist, or simply in search of professionally written lyrics, SongwriterLink connects you with a global community of talented creators.</p>
                        <p class="my-2">Our curated library features high-quality, original content in every genre—written, composed, and performed by professional lyricists and poets from around the world. From heartfelt ballads and powerful rap verses to catchy pop hooks and cinematic poetry, you’ll find creative works to suit every project and audience.</p>
                        <p class="my-2">At SongwriterLink, we make it easy to:</p>

                        <div class="flex gap-4">
                            <div><i class="fa-regular fa-badge-check"></i></div>
                            <div>Purchase lyrics and songs for personal or commercial use</div>
                        </div>

                        <div class="flex gap-4">
                            <div><i class="fa-regular fa-badge-check"></i></div>
                            <div>License or buy exclusive rights to creative content</div>
                        </div>

                        <div class="flex gap-4">
                            <div><i class="fa-regular fa-badge-check"></i></div>
                            <div>Sell your own lyrics or poems and gain global exposure</div>
                        </div>

                        <p class="my-6">Explore. Discover. Create. Only at SongwriterLink.</p>
                    </div>


                    <ul class="flex gap-3 text-sm leading-normal">
                        <a
                            href="/buy-lyrics"
                            class="
                            rounded-sm bg-[#e8363c] px-5 py-2 my-4 text-lg leading-normal text-white hover:border-black hover:bg-black"
                        >
                            Explore Lyrics & Poems
                        </a>
                    </ul>
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

        <div class="gap-4 p-6 lg:p-12 text-center justify-around">

            <h3 class="text-4xl my-4 font-bold">New work by our writers​</h3>

            <div class="gap-4 py-12 justify-around lg:grid grid-cols-3 gap-4 text-left">
                <!-- Loop through lyrics -->
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
                        
                        <pre class="whitespace-pre-wrap my-6 text-sm">{{ $lyric->snippet }}</pre>

                        <p class="my-2 text-gray-600">Genre: {{ $lyric['genre'] }}</p>
                        <p class="my-2 mb-6 font-bold">Price: ${{ $lyric['price'] }}</p>

                        <div class="xl:flex gap-2">
                            <div class="mt-4 xl:mt-2"><a
                                href="{{ route('lyrics.show', $lyric->slug) }}"
                                class="
                                rounded-sm bg-[#e8363c] px-5 py-2 my-4 text-lg leading-normal text-white hover:border-black hover:bg-black"
                            >
                                <i class="fa-sharp-duotone fa-solid fa-eye"></i> View Full Lyric
                            </a></div>
                            @if (auth()->id() && $lyric->user_id !== auth()->id())
                                <div class="mt-4 xl:mt-0"><livewire:save-lyric-button :lyric="$lyric" :key="$lyric->id" /></div>
                            @else
                                <div class="mt-4 xl:mt-0 pt-2"><a href="/login" class="mt-4"><span class="px-3 text-green-700">
                                    <i class="fa-sharp-duotone fa-regular fa-plus text-xl"></i> Log in to Save
                                </span></a></div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                <a
                    href="/buy-lyrics"
                    class="
                    rounded-sm bg-[#e8363c] px-5 py-2 my-4 text-lg leading-normal text-white hover:border-black hover:bg-black"
                >
                    View More Lyrics
                </a>
            </div>
        </div>

        <div class="md:grid grid-cols-2 gap-12 bg-gray-900 text-white lg:p-12">
            <div>
                <img src="/storage/lyricist4.jpg" alt="A person writing lyrics" />
                <div class="-mt-24 bg-gray-900 p-12 relative opacity-70">
                    <h2 class="text-3xl font-bold mb-8">Buy Lyrics Online</h2>
                    <h4 class="text-xl my-2 font-bold">Discover Orginal Music and Lyrics - Free to Search, Easy to Licence</h4>
                    <p class="my-2">Explore our extensive <b>lyric lbirbary for free</b> at SongwriterLink. 
                    Whether you're <b>a composer in need of powerful lyrics</b>, or a <b>creative professional</b> looking for a custom-written 
                    song tailored to your exact brief - our global network of skilled songwriters and lyricists are ready to 
                    help bring your vision to life.</p>
                    <p class="my-2">At SongwriterLink, you can:</p>
                    <ul class="ml-4 mb-4 flex flex-col lg:mb-6 list-disc">
                        <li>Browse and preview thousands of <b>original lyrics</b> across every genre</li>
                        <li><b>Commission bespoke lyrics</b> written to your exact specifications</li>
                    </ul>
                    <p class="my-2">If you're creating for <b>TV, film, advertising, theatre</b> or personal use, 
                    our marketplace makes it simpole to find and licence <b>authentic, high-quality creative content</b> 
                    - all in one place.</p>
                    <p class="my-2">No subscription, no hassle. Start your search today with <b>SongwriterLink</b>.</p>
                </div>
            </div>
            <div>
                <img src="/storage/lyricist3.jpg" alt="A person writing lyrics" />
                <div class="-mt-24 bg-gray-900 p-12 relative opacity-70">
                    <h2 class="text-3xl font-bold mb-8">Sell Lyrics Online</h2>
                    <h4 class="text-xl my-2 font-bold">At SongwriterLink, we're always on the lookout for <b>gifted lyricists and poets</b>
                    across all genres - from pop and hip-hop to rock, soul, indie, and everything in between.</h4>
                    <p class="my-2">To maintain the <b>integrity, originality, and professional standard</b>
                    of our platform, we carefully review all lyric submissions. We accept only the best - lyrics that showcase 
                    <b>literary craftsmanship, music flow</b> and <b>emotional impact</b>.</p>
                    <p class="my-2">We value:</p>
                    <ul class="ml-4 mb-4 flex flex-col lg:mb-6 list-disc">
                        <li>Use of poetic devices susch as <b>metaphor, personification, imagery, alliteration</b></li>
                        <li>Lyrics that are <b>authentic, creative, lyrically engaging</b></li>
                        <li>Work that demonstrates <b>emotional depth, narrative strength, original voice</b></li>
                    </ul>
                    <p class="my-2">Think your lyrics belong in front of a global audience? Submit your work to <b>SongwriterLink</b> 
                    and join a passionate community of serious songwriters.</p>
                </div>
            </div>
        </div>

        <div class="md:grid grid-cols-2 gap-12 p-4 lg:mt-12">
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
        </div>

        <h3 class="text-4xl mt-12 font-bold text-center">Latest Songwriting Articles​</h3>

        <div class="gap-4 p-6 lg:px-12 py-12 text-left justify-around lg:grid grid-cols-3 gap-4">
    
            @foreach ($blogs as $blog)
                <div class="p-4 border rounded mb-4">
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
