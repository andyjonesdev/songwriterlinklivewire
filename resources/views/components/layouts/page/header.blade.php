 <!-- <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
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
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header> -->
        


<header
            class="not-has-[nav]:hidden"
        >
            <nav class="lg:flex items-center justify-between gap-4">
                <div class="flex gap-2">

                    <a
                        href="/"
                        class="uppercase lg:mt-0 bg-gray-200 lg:bg-white inline-block px-5 py-2 text-sm leading-normal text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-red-100"
                    >
                        <img src="/storage/songwriterlink_logo.png" alt="Songwriter Link logo" class="h-8" />
                    </a>

                    <a
                        href="/"
                        class="lg:mt-0 bg-gray-200 lg:bg-white inline-block px-5 py-2 text-sm leading-normal text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-red-100"
                    >
                        <h3 class="dark:text-white text-2xl">Songwriter Link</h3>
                    </a>
                </div>
                    <div class="flex flex-wrap gap-3 mt-2">
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
                            :href="register()"
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
                        
                        <a
                            v-if="!user"
                            :href="login()"
                            class="uppercase lg:mt-0 bg-gray-200 lg:bg-white lg:dark:bg-[#0a0a0a] inline-block px-2 py-2 text-sm leading-normal text-[#6c6c6c] dark:text-[#EDEDEC] hover:bg-red-100"
                        >
                           
                        <LogIn />
</a>
                        <a
                            v-if="!user"
                            :href="register()"
                            class="uppercase lg:mt-0 bg-gray-200 lg:bg-white lg:dark:bg-[#0a0a0a] inline-block px-2 py-2 text-sm leading-normal text-[#6c6c6c] dark:text-[#EDEDEC] hover:bg-red-100"
                        >
                            <UserPlus />
</a>
                        <div v-if="user">
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
                        </div>
                    </div>
            </nav>
        </header>

    {{ $slot }}
