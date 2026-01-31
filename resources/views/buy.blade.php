<x-layouts.page :title="__('Buy Song Lyrics | Original Lyrics Marketplace - SongwriterLink')" :description="__('Buy original song lyrics from professional writers. Browse unique, high-quality lyrics for all genres—perfect for your next music project.')">
    
        <div class="flex flex-col px-6 text-[#1b1b18] lg:justify-between lg:px-8">
            <nav class="text-sm text-gray-600 mb-4">
                <a href="/">Home</a> ›
                <span>Buy Lyrics</span>
            </nav>
            <div class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
                <main
                    class="flex w-full flex-col-reverse overflow-hidden rounded-t-lg lg:flex-row">
                    <div class="flex-1 rounded-t-lg p-4 lg:p-0 pb-12 text-[13px] leading-[20px] bg-[#ffffff78] bg-gray-50 lg:pt-20 lg:px-20 lg:pb-12">
                        <h1 class="mb-1 font-medium text-6xl">Buy Original Song Lyrics</h1>

                        <p class="mt-4 text-lg flex gap-2 flex-wrap">
                        Browse by genre:
                        <a href="/buy-pop-lyrics" class="text-red-600 underline bg-gray-200 px-2">Pop Lyrics</a>
                        <a href="/buy-rap-lyrics" class="text-red-600 underline bg-gray-200 px-2">Rap Lyrics</a>
                        <a href="/buy-country-lyrics" class="text-red-600 underline bg-gray-200 px-2">Country Lyrics</a>
                        <a href="/buy-rock-lyrics" class="text-red-600 underline bg-gray-200 px-2">Rock Lyrics</a>
                        <a href="/buy-indie-lyrics" class="text-red-600 underline bg-gray-200 px-2">Indie Lyrics</a>
                        <a href="/buy-metal-lyrics" class="text-red-600 underline bg-gray-200 px-2">Metal Lyrics</a>
                        <a href="/buy-randb-lyrics" class="text-red-600 underline bg-gray-200 px-2">R&B Lyrics</a>
                        <a href="/buy-singer-songwriter-lyrics" class="text-red-600 underline bg-gray-200 px-2">Singer-Songwriter Lyrics</a>
                        <a href="/buy-jazz-lyrics" class="text-red-600 underline bg-gray-200 px-2">Jazz Lyrics</a>
                        <a href="/buy-christian-lyrics" class="text-red-600 underline bg-gray-200 px-2">Christian Lyrics</a>
                        <a href="/buy-folk-lyrics" class="text-red-600 underline bg-gray-200 px-2">Folk Lyrics</a>
                        <a href="/buy-world-lyrics" class="text-red-600 underline bg-gray-200 px-2">World Lyrics</a>
                        <a href="/buy-soul-lyrics" class="text-red-600 underline bg-gray-200 px-2">Soul Lyrics</a>
                        <a href="/buy-reggae-lyrics" class="text-red-600 underline bg-gray-200 px-2">Reggae Lyrics</a>
                        </p>
                    </div>  
                </main>
            </div>

            
            <form method="GET" action="{{ route('buyLyrics') }}" class="
            p-4 lg:flex flex-wrap gap-4 items-center justify-between bg-gray-100 rounded-b-lg">
                {{-- Genre --}}
                <div class="flex gap-2 items-center my-2">
                    <label>Genre:</label>
                    <select name="genre" class="border rounded" onchange="this.form.submit()">
                        <option value="">All</option>
                        @foreach ($genres as $genre)
                            <option value="{{ $genre }}" @selected(request('genre') === $genre)>
                                {{ $genre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Mood --}}
                <div class="flex gap-2 items-center my-2">
                    <label>Mood:</label>
                    <select name="mood" class="border rounded" onchange="this.form.submit()">
                        <option value="">All</option>
                        @foreach ($moods as $mood)
                            <option value="{{ $mood }}" @selected(request('mood') === $mood)>
                                {{ $mood }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Theme --}}
                <div class="flex gap-2 items-center my-2">
                    <label>Theme:</label>
                    <select name="theme" class="border rounded" onchange="this.form.submit()">
                        <option value="">All</option>
                        @foreach ($themes as $theme)
                            <option value="{{ $theme }}" @selected(request('theme') === $theme)>
                                {{ $theme }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- POV --}}
                <div class="flex gap-2 items-center my-2">
                    <label>POV:</label>
                    <select name="pov" class="border rounded" onchange="this.form.submit()">
                        <option value="">All</option>
                        @foreach ($povs as $pov)
                            <option value="{{ $pov }}" @selected(request('pov') === $pov)>
                                {{ $pov }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Language --}}
                <div class="flex gap-2 items-center my-2">
                    <label>Language:</label>
                    <select name="language" class="border rounded" onchange="this.form.submit()">
                        <option value="">English</option>
                        @foreach ($languages as $language)
                            <option value="{{ $language }}" @selected(request('language') === $language)>
                                {{ $language }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
            
            @if (count($lyrics_promoted)>0)
            <div class="gap-4 py-12 justify-around lg:grid grid-cols-3 gap-4">
                @foreach ($lyrics_promoted as $lyric)
                    <div class="relative p-4 border rounded mb-4 bg-white">

                        <!-- PROMOTED BADGE -->
                        <span class="absolute top-0 right-0 bg-yellow-300 text-sm px-3 py-1 rounded-bl">
                            PROMOTED
                        </span>

                        <a
                            href="{{ route('lyrics.show', $lyric->slug) }}"
                            class="text-2xl font-semibold hover:underline"
                        >
                            {{ $lyric->title }}
                        </a>

                        <br />Written By:

                        <a
                            href="{{ route('users.show', $lyric->user) }}"
                            class="font-semibold hover:underline"
                        >
                            {{ $lyric->user->name }}
                        </a>

                        <br /><span class="text-gray-400 text-sm mt-1">Posted: {{ $lyric->created_at->format('F j, Y') }}</span>
                        
                        <pre class="whitespace-pre-wrap my-6 text-sm">{{ $lyric->snippet }}</pre>

                        <p class="my-2 text-gray-600">Genre: {{ $lyric->genre }}</p>
                        <p class="my-2 mb-6 font-bold">Price: ${{ $lyric->price }}</p>

                        <div class="xl:flex gap-2">
                            <button
                                onclick="window.location.href='{{ route('lyrics.show', $lyric->slug) }}'"
                                class="rounded-sm bg-[#e8363c] px-5 py-1 my-1 text-lg text-white hover:bg-black"
                            >
                                <i class="fa-sharp-duotone fa-solid fa-eye"></i> View Full Lyric
                            </button>
                            
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
            </div>
            @endif

            <div class="gap-4 py-12 justify-around lg:grid grid-cols-3 gap-4">
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

            <div class="mt-8 mx-8">
                {{ $lyrics->links() }}
            </div>
        </div>
        
    </div>

        


</x-layouts.page>
