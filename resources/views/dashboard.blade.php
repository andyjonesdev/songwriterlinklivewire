<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div>
            <div class="h-48 w-full relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                  <h1 class="text-3xl mb-4">Welcome, {{ $user['name'] }}</h1>
                  <p>Use this page to manage your account.</p>
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <h2 class="text-2xl mb-8">Your Lyrics</h2>
            <p class="my-8"><a href="/lyrics/create" class="rounded-sm border bg-[#e8363c] px-5 py-2 text-lg leading-normal text-white hover:border-black 
            hover:bg-black dark:border-[#e8363c] dark:bg-[#e8363c] dark:text-[#1C1C1A] 
            dark:hover:border-white dark:hover:bg-white">Upload New Lyric</a></p>
            
            <div class="text-lg grid grid-cols-3 lg:grid-cols-6 py-4 border-b-2 border-gray-100">
                <div class="font-bold col-span-2">Title</div>
                <div class="font-bold hidden lg:block">Genre</div>
                <div class="font-bold hidden lg:block">Price</div>
                <div class="font-bold hidden lg:block">Status</div>
                <div class="font-bold"></div>
            </div>
            
            <div class="text-lg grid grid-cols-3 lg:grid-cols-6 my-4 bg-gray-50 dark:bg-gray-900 p-2">
                @foreach ($lyrics as $lyric)
                    <div class="col-span-2">{{ $lyric['title'] }}</div>
                    <div class="hidden lg:block">{{ $lyric['genre'] }}</div>
                    <div class="hidden lg:block">${{ $lyric['price'] }}</div>
                    <div class="hidden lg:block">{{ $lyric['status'] }}</div>
                    <a :href="lyricsEdit.url({ slug: lyric.slug })" class="underline">Edit</a>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.app>
