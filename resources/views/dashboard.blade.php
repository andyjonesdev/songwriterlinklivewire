<x-layouts.app :title="__('Buy Original Song Lyrics: Songwriter Link')" :description="__('Buy original song lyrics from professional writers. Browse unique, high-quality lyrics for all genres—perfect for your next music project.')">

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div>
            <div class="w-full rounded-xl border border-sidebar-border/70 p-6">
                <h1 class="text-3xl mb-4">Welcome, {{ $user['name'] }}</h1>
                <p>Use this page to manage your account.</p>
                @livewire('social-usage-consent')
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 p-6">

            @if (auth()->user()->role=='seller')
                <h2 class="text-2xl mb-8">Your Lyrics</h2>
                <p class="my-8"><a href="/lyrics/create" class="rounded-sm bg-[#e8363c] px-5 py-2 text-lg leading-normal text-white hover:border-black 
                hover:bg-black">Upload New Lyric</a></p>
                
                <div class="text-lg grid grid-cols-2 lg:grid-cols-5 py-4 border-b-2 border-gray-100">
                    <div class="font-bold col-span-2">Title</div>
                    <div class="font-bold hidden lg:block">Genre</div>
                    <div class="font-bold hidden lg:block">Price</div>
                    <div class="font-bold hidden lg:block">Status</div>
                    <!-- <div class="font-bold"></div> -->
                </div>
                
                <div class="text-lg grid grid-cols-2 lg:grid-cols-5 my-4">
                    @foreach ($lyrics as $lyric)
                        <div class="col-span-2 mb-2 bg-gray-50 px-2">{{ $lyric['title'] }}</div>
                        <div class="hidden lg:block mb-2 bg-gray-50">{{ $lyric['genre'] }}</div>
                        <div class="hidden lg:block mb-2 bg-gray-50">${{ $lyric['price'] }}</div>
                        <div class="hidden lg:block mb-2 bg-gray-50">{{ $lyric['status'] }}</div>
                        <!-- <a :href="lyricsEdit.url({ slug: lyric.slug })" class="underline">Edit</a> -->
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
