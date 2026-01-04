<x-layouts.page :title="__($user->name . ' - Profile')" :description="__('View the profile and lyrics of ' . $user->name)">
    
    <div class="flex flex-col px-6 text-[#1b1b18] lg:justify-between lg:px-8 dark:bg-[#0a0a0a]">
    
        {{-- User header --}}
        <div class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow">
            <main class="flex w-full flex-col-reverse overflow-hidden rounded-lg lg:flex-row">
                <div class="p-6 flex-1 rounded-lg pb-12 text-[13px] leading-[20px]
                    bg-[#ffffff78] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)]
                    lg:p-20 dark:bg-[#161615ba] dark:text-[#EDEDEC]
                    dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">

                    <h1 class="mb-1 font-medium text-6xl">
                        {{ $user->name }}
                    </h1>

                    <p class="my-4 text-lg">
                        <i>Lyricist</i>
                    </p>

                    <p class="my-4 text-lg lg:w-2/3">
                        {{ $user->bio }}
                    </p>
                </div>
            </main>
        </div>

        {{-- Lyrics list --}}
        <div class="dark:text-white py-12 text-center">
            <h3 class="text-4xl my-4 font-bold">
                Lyrics by {{ $user->name }}
            </h3>

            <div class="dark:text-white py-12 lg:grid grid-cols-3 gap-4">
                @forelse ($lyrics as $lyric)
                    <div class="p-4 border rounded mb-4">
                        <h2 class="text-2xl font-semibold">
                            <a
                                href="{{ url('/lyrics/buy/' . $lyric->slug) }}"
                                class="hover:underline"
                            >
                                {{ $lyric->title }}
                            </a>
                        </h2>

                        <h3>
                            Written By:
                            <a href="{{ route('users.show', $user) }}">
                                <b>{{ $user->name }}</b>
                            </a>
                        </h3>

                        <p class="text-gray-600 mt-2">
                            {{ $lyric->snippet }}
                        </p>

                        <p class="my-2 text-gray-600">
                            Genre: {{ $lyric->genre }}
                        </p>

                        <p class="my-2 mb-6 font-bold">
                            Price: ${{ $lyric->price }}
                        </p>

                        <a
                            href="{{ url('/lyrics/buy/' . $lyric->slug) }}"
                            class="
                                rounded-sm border bg-[#e8363c] px-5 py-2 my-4 text-lg
                                leading-normal text-white hover:border-black hover:bg-black
                                dark:border-[#e8363c] dark:bg-[#e8363c]
                                dark:text-[#1C1C1A] dark:hover:border-white dark:hover:bg-white
                            "
                        >
                            View Full Lyric
                        </a>
                    </div>
                @empty
                    <p class="col-span-3 text-gray-500">
                        No lyrics published yet.
                    </p>
                @endforelse
            </div>
        </div>
        
    </div>

</x-layouts.page>
