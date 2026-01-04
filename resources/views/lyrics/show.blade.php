<x-layouts.page :title="__($lyric->title. ' - Songwriter Link Original Song Lyrics')" :description="__('Song Lyrics by ' . $lyric->user->name)">
    
    <div class="flex flex-col px-6 text-[#1b1b18] lg:justify-between lg:px-8 dark:bg-[#0a0a0a]">
    
        <div class="flex w-full opacity-100 transition-opacity duration-750 lg:grow">
        <main class="flex lg:w-2/3 flex-col overflow-hidden rounded-lg">

            <div class="flex-1 rounded-lg p-4 pb-12 text-[13px] leading-[20px]
                bg-[#ffffff78] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)]
                lg:p-20 dark:bg-[#161615ba] dark:text-[#EDEDEC]
                dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">

                <h1 class="mb-4 font-medium text-6xl">
                    {{ $lyric->title }}
                </h1>

                <h2 class="text-lg">
                    Written By:
                    <b>{{ $lyric->user->name ?? 'Unknown' }}</b>
                </h2>

                <h3 class="text-lg">
                    Genre:
                    <b>{{ $lyric->genre }}</b>
                </h3>

                <pre class="whitespace-pre-wrap my-6 bg-gray-50 p-4 dark:bg-gray-900">
                    {{ $lyric->content }}
                </pre>

                <h4 class="text-lg font-semibold mt-6">
                    Standard License Terms
                </h4>

                <p class="my-2 text-lg">
                    The following rights are granted:
                </p>

                <ul class="list-disc ml-8 text-lg">
                    <li>Public performance rights</li>
                    <li>Synchronization rights for video/visual content</li>
                    <li>Internet broadcasting rights</li>
                    <li>Reproduction rights for CD, DVD, and digital downloads</li>
                    <li>Radio and television broadcast rights</li>
                    <li>Film, games, and musical theatre usage</li>
                </ul>

                <h3 class="text-2xl my-6">
                    Price: <b>${{ $lyric->price }}</b>
                </h3>

                <p class="my-8 p-2 bg-yellow-100 dark:bg-gray-900 text-lg">
                    <b>Important!</b>
                    This lyric is not available for use unless you purchase the licence.
                </p>

                {{-- Buy button --}}
                @guest
                    <p class="text-lg my-4">To buy a licence for this lyric, please register or login first.</p>
                    <a
                        href="/register"
                        class="rounded-sm border bg-[#e8363c] px-5 py-2 my-4 text-lg
                               leading-normal text-white hover:border-black hover:bg-black
                               dark:border-[#e8363c] dark:bg-[#e8363c]
                               dark:text-[#1C1C1A] dark:hover:border-white dark:hover:bg-white">
                        Register
                    </a>
                    <a
                        href="/login"
                        class="rounded-sm border bg-[#e8363c] px-5 py-2 my-4 text-lg
                               leading-normal text-white hover:border-black hover:bg-black
                               dark:border-[#e8363c] dark:bg-[#e8363c]
                               dark:text-[#1C1C1A] dark:hover:border-white dark:hover:bg-white">
                        Log in
                    </a>
                @else
                    <a
                        href="https://buy.stripe.com/4gMaEQ7Zs7LI4UzfeSbo400?prefilled_email={{ auth()->user()->email }}&client_reference_id=lyric-{{ auth()->id() }}-{{ $lyric->id }}"
                        class="rounded-sm border bg-[#e8363c] px-5 py-2 my-4 text-lg leading-normal text-white hover:border-black hover:bg-black dark:border-[#e8363c] dark:bg-[#e8363c] dark:text-[#1C1C1A] dark:hover:border-white dark:hover:bg-white"
                    >
                        Buy Now
                    </a>
                @endguest

            </div>
        </main>
    </div>
        
    </div>

</x-layouts.page>
