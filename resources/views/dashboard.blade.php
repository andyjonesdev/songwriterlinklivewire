<x-layouts.app :title="__('Buy Original Song Lyrics: Songwriter Link')" :description="__('Buy original song lyrics from professional writers. Browse unique, high-quality lyrics for all genres—perfect for your next music project.')">

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div>
            <div class="w-full rounded-xl border border-sidebar-border/70 p-6">
                <h1 class="text-3xl mb-4">Welcome, {{ $user['name'] }}</h1>
                <p>Use this page to manage your account.</p>
                @if ($user['role']=='seller')
                    @livewire('social-usage-consent')
                    @livewire('marketing-consent')
                    <div class="mt-12">
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
                @endif
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 p-6">

            @if (auth()->user()->role=='seller')
                <h2 class="text-2xl mb-8">Your Lyrics</h2>
                <p class="my-8"><a href="/lyrics/create" class="rounded-sm bg-[#e8363c] px-5 py-2 text-md leading-normal text-white hover:border-black 
                hover:bg-black">Upload New Lyric</a></p>
                
                <div class="text-lg grid grid-cols-6 lg:grid-cols-10 py-4 text-sm">
                    <div class="font-bold px-2 col-span-4">Title</div>
                    <div class="font-bold px-2 hidden lg:block">Genre</div>
                    <div class="font-bold px-2 hidden lg:block">Price</div>
                    <div class="font-bold px-2 hidden lg:block">Status</div>
                    <div class="font-bold col-span-3"></div>
                </div>
                
                <div class="text-lg grid grid-cols-6 md:grid-cols-10 mb-4 text-sm">
                    @foreach ($lyrics as $lyric)
                        <div class="col-span-4 md:col-span-4 px-2 py-1 my-2 {{ $loop->odd ? 'bg-gray-100' : '' }}">
                            <b>{{ $lyric['title'] }}</b>
                        </div>
                        <div class="hidden md:block px-2 py-1 my-2 {{ $loop->odd ? 'bg-gray-100' : '' }}">{{ $lyric['genre'] }}</div>
                        <div class="hidden md:block px-2 py-1 my-2 {{ $loop->odd ? 'bg-gray-100' : '' }}">${{ $lyric['price'] }}</div>
                        <div class="hidden md:block px-2 py-1 my-2 {{ $loop->odd ? 'bg-gray-100' : '' }}">{{ $lyric['status'] }}</div>
                        <!-- <a :href="lyricsEdit.url({ slug: lyric.slug })" class="underline">Edit</a> -->

                        <div class="w-24 md:w-auto col-span-2 md:col-span-3 px-2 py-1 my-2 {{ $loop->odd ? 'bg-gray-100' : '' }}">
                            <a
                                href="{{ route('lyrics.promote', $lyric) }}"
                                class="bg-yellow-500 text-white px-2 py-1 rounded-md text-center h-fit"
                            >
                                <i class="fa-sharp-duotone fa-solid fa-up"></i>
                                <span class="hidden md:inline">Promote</span>
                            </a>&nbsp;
                            <a
                                href="https://copyrightsolved.com" target="_blank"
                                class="bg-green-700 text-white px-2 py-1 rounded-md text-center h-fit"
                            >
                                <i class="fa-sharp-duotone fa-solid fa-file-lock"></i>
                                <span class="hidden md:inline">Protect</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
            @if (auth()->user()->role=='buyer')
                <h2 class="text-2xl mb-8">Your Purchased Lyrics</h2>
                
                <div class="text-lg grid grid-cols-3 lg:grid-cols-5 py-4 border-b-2 border-gray-100">
                    <div class="font-bold col-span-2">Title</div>
                    <div class="font-bold hidden lg:block">Genre</div>
                    <div class="font-bold hidden lg:block">Price</div>
                    <div class="font-bold hidden lg:block">Status</div>
                    <!-- <div class="font-bold"></div> -->
                </div>
                
                <div class="text-lg grid grid-cols-3 lg:grid-cols-5 my-4">
                    @foreach ($lyrics as $lyric)
                        <div class="col-span-2 mb-2 bg-gray-50 px-2">{{ $lyric['title'] }}</div>
                        <div class="hidden lg:block mb-2 bg-gray-50">{{ $lyric['genre'] }}</div>
                        <div class="hidden lg:block mb-2 bg-gray-50">${{ $lyric['price'] }}</div>
                        <div class="hidden lg:block mb-2 bg-gray-50">{{ $lyric['status'] }}</div>
                        <!-- <a :href="lyricsEdit.url({ slug: lyric.slug })" class="underline">Edit</a> -->
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
