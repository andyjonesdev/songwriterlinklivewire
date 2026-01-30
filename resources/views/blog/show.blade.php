<x-layouts.page :title="__($blog->title)" :description="__($blog->description)">
    
    <div class="flex flex-col px-6 text-[#1b1b18] lg:justify-between lg:px-8">
        <nav class="text-sm text-gray-600 mb-4">
            <a href="/">Home</a> ›
            <a href="/blog">Blog</a> ›
            <span>{{ $blog->title }}</span>
        </nav>
        <div class="flex w-full opacity-100 transition-opacity duration-750 lg:grow">
            <main
                class="flex lg:w-2/3 flex-col-reverse overflow-hidden rounded-lg lg:flex-row"
            >
                <div
                    class="p-6 flex-1 rounded-lg pb-12 text-[13px] leading-[20px]
                    bg-[#ffffff78] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)]
                    lg:p-20"
                >
                    <h1 class="mb-4 font-medium text-4xl lg:text-6xl">
                        {{ $blog->title }}
                    </h1>

                    <h3 class="text-lg mb-6">
                        Category:
                        <b>{{ $blog->category }}</b>
                    </h3>

                    <div class="whitespace-pre-wrap my-6 text-lg">{!! $blog->content !!}</div>
                </div>
            </main>
        </div>
        
    </div>

</x-layouts.page>
