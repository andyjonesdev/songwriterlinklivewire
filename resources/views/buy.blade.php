<x-layouts.page :title="__('Buy Original Song Lyrics: Songwriter Link')" :description="__('Buy original song lyrics from professional writers. Browse unique, high-quality lyrics for all genres—perfect for your next music project.')">
    
        <div class="flex flex-col px-6 text-[#1b1b18] lg:justify-between lg:px-8">
    
            <div class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
                <main
                    class="flex w-full flex-col-reverse overflow-hidden rounded-t-lg lg:flex-row">
                    <div class="flex-1 rounded-t-lg p-4 lg:p-0 pb-12 text-[13px] leading-[20px] bg-[#ffffff78] bg-gray-50 lg:pt-20 lg:px-20 lg:pb-12">
                        <h1 class="mb-1 font-medium text-6xl">Buy lyrics & poems</h1>
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
                        <option value="">All</option>
                        @foreach ($languages as $language)
                            <option value="{{ $language }}" @selected(request('language') === $language)>
                                {{ $language }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>


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

                                <pre class="whitespace-pre-wrap my-6 text-sm">{{ $lyric->snippet }}</pre>

                                <p class="my-2 text-gray-600">Genre: {{ $lyric['genre'] }}</p>
                                <p class="my-2 mb-6 font-bold">Price: ${{ $lyric['price'] }}</p>
                                <a
                                    href="{{ route('lyrics.show', $lyric->slug) }}"
                                    class="
                                    rounded-sm bg-[#e8363c] px-5 py-2 my-4 text-lg leading-normal text-white hover:border-black hover:bg-black"
                                >
                                    View Full Lyric
                                </a>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-8 mx-8">
                {{ $lyrics->links() }}
            </div>
        </div>
        
    </div>

        


</x-layouts.page>
