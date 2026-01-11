<div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">

    {{-- Header / Create --}}
    <div class="h-16">
        <div class="relative aspect-video overflow-hidden py-6">
            <a
                href="{{ route('blog.create') }}"
                class="rounded-sm bg-[#e8363c] px-5 py-2 text-lg leading-normal text-white hover:border-black 
                       hover:bg-black dark:border-[#e8363c] dark:bg-[#e8363c] dark:text-[#1C1C1A] 
                       dark:hover:border-white dark:hover:bg-white"
            >
                Upload New Blog Post
            </a>
        </div>
    </div>

    {{-- Content --}}
    <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border px-6">

        @if (session()->has('success'))
            <div class="my-4 text-green-600">
                {{ session('success') }}
            </div>
        @endif

        @foreach ($blogs as $blog)
            <div class="pt-4 pb-8 flex gap-8 my-4 border-b border-gray-100">

                <div class="w-2/3 pr-8 border-r border-gray-100">
                    <h2 class="font-semibold text-lg">
                        {{ $blog->title }}
                    </h2>
                </div>

                <div>
                    <div class="flex gap-4 my-4">

                        <a
                            href="{{ route('blog.show', $blog->slug) }}"
                            class="bg-red-900 text-white px-2 py-1 rounded-md"
                        >
                            View
                        </a>

                        <a
                            href="{{ route('blog.edit', $blog) }}"
                            class="bg-red-700 text-white px-2 py-1 rounded-md"
                        >
                            Edit
                        </a>

                        <button
                            wire:click="delete({{ $blog->id }})"
                            onclick="return confirm('Delete this blog?')"
                            class="bg-gray-500 text-white px-2 py-1 rounded-md"
                        >
                            Delete
                        </button>

                    </div>
                </div>
            </div>
        @endforeach

        {{-- Pagination --}}
        <div class="my-6">
            {{ $blogs->links() }}
        </div>
    </div>
</div>
