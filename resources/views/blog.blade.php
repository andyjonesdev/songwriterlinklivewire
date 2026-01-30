<x-layouts.page :title="__('Blog - SongwriterLink')" :description="__('Articles about music and songwriting by SongwriterLink')">

        <div class="flex flex-col px-6 text-[#1b1b18] lg:justify-between lg:px-8">
            <nav class="text-sm text-gray-600 mb-4">
                <a href="/">Home</a> ›
                <span>Blog</span>
            </nav>
            <div class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
                <main
                    class="flex w-full flex-col-reverse overflow-hidden rounded-lg lg:flex-row">
                    <div class="flex-1 rounded-lg p-4 lg:p-0 pb-12 text-[13px] leading-[20px] bg-[#ffffff78] bg-gray-50 lg:p-20">
                        <h1 class="mb-1 font-medium text-6xl">Blog</h1>
                    </div>  
                </main>
            </div>

            <!-- Blog Grid -->
            <div class="py-12 text-center lg:grid grid-cols-3 gap-4">
                @foreach ($blogs as $blog)
                    <div class="p-4 border rounded mb-4">
                        <a
                            href="{{ route('blog.show', $blog->slug) }}"
                            class="text-2xl font-semibold hover:underline"
                        >
                            {{ $blog->title }}
                        </a>

                        <div class="my-6 text-gray-600">
                            {!! $blog->snippet !!}
                        </div>

                        <p class="my-4 text-gray-600">
                            Category: {{ $blog->category }}
                        </p>

                        <a
                            href="{{ route('blog.show', $blog->slug) }}"
                            class="
                                inline-block rounded-sm bg-[#e8363c]
                                px-5 py-2 my-4 text-lg leading-normal text-white
                                hover:border-black hover:bg-black
                            "
                        >
                            View Article
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $blogs->links() }}
            </div>
        </div>
        
    </div>

</x-layouts.page>
