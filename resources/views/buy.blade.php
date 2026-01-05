<x-layouts.page :title="__('Buy Original Song Lyrics: Songwriter Link')" :description="__('Buy original song lyrics from professional writers. Browse unique, high-quality lyrics for all genres—perfect for your next music project.')">
    
        <div class="flex flex-col px-6 text-[#1b1b18] lg:justify-between lg:px-8">
    
            <div class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
                <main
                    class="flex w-full flex-col-reverse overflow-hidden rounded-lg lg:flex-row">
                    <div class="flex-1 rounded-lg p-4 lg:p-0 pb-12 text-[13px] leading-[20px] bg-[#ffffff78] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] lg:p-20">
                        <h1 class="mb-1 font-medium text-6xl">Buy lyrics & poems</h1>
                    </div>  
                </main>
            </div>

            <div class="hidden p-2 my-4 flex gap-2">
                <div>Select a genre:</div>
                <select @change="filterGenre" class="border rounded">
                    <option value="">All Genres</option>
                    <option value="Rap" :selected="props.selectedGenre === 'Rap'">Rap</option>
                    <option value="Pop" :selected="props.selectedGenre === 'Pop'">Pop</option>
                    <option value="R&B" :selected="props.selectedGenre === 'R&B'">R&B</option>
                    <option value="Rock" :selected="props.selectedGenre === 'Rock'">Rock</option>
                    <option value="Country" :selected="props.selectedGenre === 'Country'">Country</option>
                    <option value="Hip-hop" :selected="props.selectedGenre === 'Hip-hop'">Hip-hop</option>
                    <option value="Indie" :selected="props.selectedGenre === 'Indie'">Indie</option>
                    <option value="Electronic" :selected="props.selectedGenre === 'Electronic'">Electronic</option>
                    <option value="Ethnic" :selected="props.selectedGenre === 'Ethnic'">Ethnic</option>
                    <option value="Classical" :selected="props.selectedGenre === 'Classical'">Classical</option>
                    <option value="Jazz" :selected="props.selectedGenre === 'Jazz'">Jazz</option>
                    <option value="K-pop" :selected="props.selectedGenre === 'K-pop'">K-pop</option>
                    <option value="Metal" :selected="props.selectedGenre === 'Metal'">Metal</option>
                    <option value="Oldies" :selected="props.selectedGenre === 'Oldies'">Oldies</option>
                    <option value="Techno" :selected="props.selectedGenre === 'Techno'">Techno</option>
                    <option value="Folk" :selected="props.selectedGenre === 'Folk'">Folk</option>
                    <option value="Blues" :selected="props.selectedGenre === 'Blues'">Blues</option>
                    <option value="Christian" :selected="props.selectedGenre === 'Christian'">Christian</option>
                    <option value="Gospel" :selected="props.selectedGenre === 'Gospel'">Gospel</option>
                    <option value="Progressive" :selected="props.selectedGenre === 'Progressive'">Progressive</option>
                    <option value="Singer-Songwriter" :selected="props.selectedGenre === 'Singer-Songwriter'">Singer-Songwriter</option>
                    <option value="Dance" :selected="props.selectedGenre === 'Dance'">Dance</option>
                    <option value="Funk" :selected="props.selectedGenre === 'Funk'">Funk</option>
                    <option value="Soul" :selected="props.selectedGenre === 'Soul'">Soul</option>
                    <option value="Reggae" :selected="props.selectedGenre === 'Reggae'">Reggae</option>
                    <option value="World" :selected="props.selectedGenre === 'World'">World</option>
                    <option value="Other" :selected="props.selectedGenre === 'Other'">Other</option>
                </select>
            </div>

                <div class="gap-4 py-12 text-center justify-around lg:grid grid-cols-3 gap-4">
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

                            <p class="text-gray-600 mt-2">
                                {{ $lyric['snippet'] }}
                            </p>

                            <p class="my-2 text-gray-600">Genre: {{ $lyric['genre'] }}</p>
                            <p class="my-2 mb-6 font-bold">Price: ${{ $lyric['price'] }}</p>
                            <a
                                href="{{ route('lyrics.show', $lyric->slug) }}"
                                class="
                                rounded-sm border bg-[#e8363c] px-5 py-2 my-4 text-lg leading-normal text-white hover:border-black hover:bg-black"
                            >
                                View Full Lyric
                            </a>
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>

            <div class="mt-8 mx-8">
                {{ $lyrics->links() }}
            </div>
        </div>
        
    </div>

        


</x-layouts.page>
