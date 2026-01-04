<header class="not-has-[nav]:hidden">
            <nav class="lg:flex items-center justify-between gap-4">
                <div class="flex gap-2 my-8">

                    <a
                        href="/"
                        class="uppercase lg:mt-0 bg-gray-200 lg:bg-white inline-block pl-8 py-2 text-sm leading-normal text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-red-100"
                    >
                        <img src="/storage/songwriterlink_logo.png" alt="Songwriter Link logo" class="h-8" />
                    </a>

                    <a
                        href="/"
                        class="lg:mt-0 bg-gray-200 lg:bg-white inline-block pr-5 py-2 text-sm leading-normal text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-red-100"
                    >
                        <h3 class="dark:text-white text-2xl">Songwriter Link</h3>
                    </a>
                </div>
                    <div class="flex flex-wrap gap-3 my-8">
                        <a
                            href="/"
                            class="uppercase g:mt-0 bg-gray-200 lg:bg-white lg:dark:bg-[#0a0a0a] inline-block px-5 py-2 text-sm leading-normal text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-red-100"
                        >
                            Home
                        </a>
                        <a
                            href="/buy-lyrics"
                            class="uppercase lg:mt-0 bg-gray-200 lg:bg-white lg:dark:bg-[#0a0a0a] inline-block px-5 py-2 text-sm leading-normal text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-red-100"
                        >
                            Buy Lyrics
                        </a>
                        <a
                            href="/register"
                            class="uppercase lg:mt-0 bg-gray-200 lg:bg-white lg:dark:bg-[#0a0a0a] inline-block px-5 py-2 text-sm leading-normal text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-red-100"
                        >
                            Sell Lyrics
                        </a>
                        <a
                            href="/blog"
                            class="uppercase lg:mt-0 bg-gray-200 lg:bg-white lg:dark:bg-[#0a0a0a] inline-block px-5 py-2 text-sm leading-normal text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-red-100"
                        >
                            Blog
                        </a>
                        <a
                            href="/faqs"
                            class="uppercase lg:mt-0 bg-gray-200 lg:bg-white lg:dark:bg-[#0a0a0a] inline-block px-5 py-2 text-sm leading-normal text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-red-100"
                        >
                            FAQs
                        </a>
                        <a
                            href="/contact"
                            class="uppercase lg:mt-0 bg-gray-200 lg:bg-white lg:dark:bg-[#0a0a0a] inline-block px-5 py-2 text-sm leading-normal text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-red-100"
                        >
                            Contact
                        </a>
                        

                        @if (Route::has('login'))
                                @auth
                                    <a
                                        href="{{ url('/dashboard') }}"
                                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                                    >
                                        Dashboard
                                    </a>
                                @else
                                    <a
                                        href="{{ route('login') }}"
                                        class="uppercase inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                                    >
                                        
                                        <i class="fa-sharp-duotone fa-solid fa-arrow-right-to-bracket text-xl"></i>
                                    </a>

                                    @if (Route::has('register'))
                                        <a
                                            href="{{ route('register') }}"
                                            class="uppercase inline-block px-5 py-1.5 dark:text-[#EDEDEC] #0a0a0ahover:border-[#1915014a] text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                            <i class="fa-sharp-duotone fa-solid fa-user-plus text-xl"></i>
                                        </a>
                                    @endif
                                @endauth
                        @endif
                        
                        <!-- <div v-if="user">
                            <a
                                v-if="user.role=='seller'"
                                :href="sellerdashboard()"
                                class="uppercase lg:mt-0 bg-gray-200 lg:bg-white inline-block px-5 py-2 text-sm leading-normal text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-red-100"
                            >
                                Your Dashboard
</a>
                            <a
                                v-if="user.role=='buyer'"
                                :href="buyerdashboard()"
                                class="uppercase lg:mt-0 bg-gray-200 lg:bg-white inline-block px-5 py-2 text-sm leading-normal text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-red-100"
                            >
                                Your Dashboard
</a>
                        </div> -->
                    </div>
            </nav>
        </header>

    {{ $slot }}
