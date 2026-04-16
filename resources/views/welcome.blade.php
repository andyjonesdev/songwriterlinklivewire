<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
        <title>SongwriterLink — The Verified Songwriter Network</title>
    </head>
    <body class="min-h-screen bg-white font-sans text-zinc-900">

        {{-- Nav --}}
        <nav class="sticky top-0 z-30 border-b border-zinc-100 bg-white/95 backdrop-blur">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
                <a href="/" class="flex items-center gap-2">
                    <img src="/storage/songwriterlink_logo.png" alt="SongwriterLink" class="h-8 w-auto" />
                    <span class="text-base font-semibold text-zinc-900">SongwriterLink</span>
                </a>
                <div class="hidden items-center gap-6 md:flex">
                    <a href="#how-it-works" class="text-sm text-zinc-500 hover:text-zinc-900">How it works</a>
                    <a href="#features" class="text-sm text-zinc-500 hover:text-zinc-900">Features</a>
                    <a href="#pricing" class="text-sm text-zinc-500 hover:text-zinc-900">Pricing</a>
                </div>
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm text-zinc-500 hover:text-zinc-900">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-zinc-500 hover:text-zinc-900">Sign in</a>
                        <a href="{{ route('onboarding.start') }}" class="rounded-lg bg-brand px-4 py-2 text-sm font-semibold text-white hover:bg-brand-dark">
                            Join free
                        </a>
                    @endauth
                </div>
            </div>
        </nav>

        {{-- Hero --}}
        <section class="relative overflow-hidden">

            {{-- Light background --}}
            <div class="absolute inset-0 bg-white"></div>

            {{-- SVG: music + connections decoration --}}
            <div class="absolute inset-0 overflow-hidden">
                <svg viewBox="0 0 1440 660" preserveAspectRatio="xMidYMid slice"
                     class="h-full w-full" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <radialGradient id="heroGlow" cx="50%" cy="45%" r="45%">
                            <stop offset="0%"   stop-color="#7c3aed" stop-opacity="0.04"/>
                            <stop offset="100%" stop-color="#7c3aed" stop-opacity="0"/>
                        </radialGradient>
                    </defs>

                    <!-- Purple radial glow behind the text -->
                    <rect width="1440" height="660" fill="url(#heroGlow)"/>

                    <!-- Musical staff lines — top left -->
                    <g stroke="#7c3aed" stroke-width="0.8" opacity="0.07">
                        <line x1="0"   y1="88"  x2="520" y2="88"/>
                        <line x1="0"   y1="104" x2="520" y2="104"/>
                        <line x1="0"   y1="120" x2="520" y2="120"/>
                        <line x1="0"   y1="136" x2="520" y2="136"/>
                        <line x1="0"   y1="152" x2="520" y2="152"/>
                    </g>

                    <!-- Musical staff lines — bottom right -->
                    <g stroke="#7c3aed" stroke-width="0.8" opacity="0.07">
                        <line x1="920" y1="510" x2="1440" y2="510"/>
                        <line x1="920" y1="526" x2="1440" y2="526"/>
                        <line x1="920" y1="542" x2="1440" y2="542"/>
                        <line x1="920" y1="558" x2="1440" y2="558"/>
                        <line x1="920" y1="574" x2="1440" y2="574"/>
                    </g>

                    <!-- Connection network edges -->
                    <g stroke="#7c3aed" stroke-width="0.7" opacity="0.16">
                        <line x1="100"  y1="210" x2="265"  y2="155"/>
                        <line x1="265"  y1="155" x2="445"  y2="235"/>
                        <line x1="100"  y1="210" x2="315"  y2="375"/>
                        <line x1="315"  y1="375" x2="445"  y2="235"/>
                        <line x1="445"  y1="235" x2="645"  y2="175"/>
                        <line x1="445"  y1="235" x2="585"  y2="415"/>
                        <line x1="645"  y1="175" x2="825"  y2="125"/>
                        <line x1="645"  y1="175" x2="765"  y2="305"/>
                        <line x1="765"  y1="305" x2="945"  y2="375"/>
                        <line x1="825"  y1="125" x2="985"  y2="185"/>
                        <line x1="985"  y1="185" x2="1165" y2="145"/>
                        <line x1="985"  y1="185" x2="1085" y2="325"/>
                        <line x1="1085" y1="325" x2="1305" y2="275"/>
                        <line x1="1165" y1="145" x2="1305" y2="275"/>
                        <line x1="315"  y1="375" x2="585"  y2="415"/>
                        <line x1="585"  y1="415" x2="765"  y2="305"/>
                        <line x1="945"  y1="375" x2="1085" y2="325"/>
                        <line x1="100"  y1="460" x2="315"  y2="375"/>
                        <line x1="1305" y1="275" x2="1385" y2="440"/>
                        <line x1="1385" y1="195" x2="1165" y2="145"/>
                        <line x1="1385" y1="195" x2="1305" y2="275"/>
                        <line x1="265"  y1="155" x2="100"  y2="210"/>
                    </g>

                    <!-- Connection nodes (filled circles) -->
                    <g fill="#7c3aed">
                        <circle cx="100"  cy="210" r="2.5" opacity="0.4"/>
                        <circle cx="265"  cy="155" r="3.5" opacity="0.55"/>
                        <circle cx="445"  cy="235" r="5.2" opacity="0.75"/>
                        <circle cx="315"  cy="375" r="3"   opacity="0.45"/>
                        <circle cx="645"  cy="175" r="4"   opacity="0.6"/>
                        <circle cx="825"  cy="125" r="2.8" opacity="0.4"/>
                        <circle cx="765"  cy="305" r="4.5" opacity="0.65"/>
                        <circle cx="945"  cy="375" r="3.5" opacity="0.5"/>
                        <circle cx="985"  cy="185" r="5.2" opacity="0.75"/>
                        <circle cx="1085" cy="325" r="3.5" opacity="0.5"/>
                        <circle cx="1165" cy="145" r="3.8" opacity="0.55"/>
                        <circle cx="1305" cy="275" r="4.5" opacity="0.6"/>
                        <circle cx="585"  cy="415" r="2.8" opacity="0.4"/>
                        <circle cx="100"  cy="460" r="2.2" opacity="0.35"/>
                        <circle cx="1385" cy="440" r="2.8" opacity="0.4"/>
                        <circle cx="1385" cy="195" r="3"   opacity="0.45"/>
                    </g>

                    <!-- Animated pulse rings on 3 hub nodes -->
                    <g fill="none" stroke="#7c3aed" stroke-width="1.2">
                        <circle cx="445" cy="235" r="5">
                            <animate attributeName="r"       values="5;24"    dur="3.5s" repeatCount="indefinite"/>
                            <animate attributeName="opacity" values="0.55;0"  dur="3.5s" repeatCount="indefinite"/>
                        </circle>
                        <circle cx="985" cy="185" r="5">
                            <animate attributeName="r"       values="5;24"    dur="3.5s" begin="1.2s" repeatCount="indefinite"/>
                            <animate attributeName="opacity" values="0.55;0"  dur="3.5s" begin="1.2s" repeatCount="indefinite"/>
                        </circle>
                        <circle cx="765" cy="305" r="5">
                            <animate attributeName="r"       values="5;24"    dur="3.5s" begin="2.4s" repeatCount="indefinite"/>
                            <animate attributeName="opacity" values="0.55;0"  dur="3.5s" begin="2.4s" repeatCount="indefinite"/>
                        </circle>
                    </g>

                    <!-- Music note 1 — lower left, quarter note -->
                    <g opacity="0.13" fill="#7c3aed" stroke="none">
                        <ellipse cx="185" cy="505" rx="9"  ry="6.5" transform="rotate(-20 185 505)"/>
                        <line   x1="193" y1="503" x2="193" y2="460" stroke="#7c3aed" stroke-width="2" fill="none"/>
                    </g>

                    <!-- Music note 2 — upper right, eighth note (with flag) -->
                    <g opacity="0.12" fill="#7c3aed" stroke="none">
                        <ellipse cx="1258" cy="118" rx="12" ry="8"  transform="rotate(-20 1258 118)"/>
                        <line   x1="1269"  y1="115" x2="1269" y2="58" stroke="#7c3aed" stroke-width="2.5" fill="none"/>
                        <path   d="M1269,58 Q1292,72 1280,91" stroke="#7c3aed" stroke-width="2.5" fill="none"/>
                    </g>

                    <!-- Music note 3 — mid left, beamed eighth-note pair -->
                    <g opacity="0.10" fill="#7c3aed">
                        <ellipse cx="58"  cy="348" rx="8" ry="5.5" transform="rotate(-20 58 348)"/>
                        <line   x1="65.5" y1="346" x2="65.5" y2="298" stroke="#7c3aed" stroke-width="2" fill="none"/>
                        <ellipse cx="93"  cy="336" rx="8" ry="5.5" transform="rotate(-20 93 336)"/>
                        <line   x1="100.5" y1="334" x2="100.5" y2="286" stroke="#7c3aed" stroke-width="2" fill="none"/>
                        <!-- beam -->
                        <polygon points="65.5,298 67.5,298 102.5,286 100.5,286"/>
                    </g>

                    <!-- Music note 4 — right edge, quarter note -->
                    <g opacity="0.11" fill="#7c3aed">
                        <ellipse cx="1392" cy="338" rx="9"   ry="6"   transform="rotate(-20 1392 338)"/>
                        <line   x1="1400"  y1="336" x2="1400" y2="292" stroke="#7c3aed" stroke-width="2" fill="none"/>
                    </g>

                    <!-- Sine / soundwave — left edge -->
                    <path d="M0,335 C22,305 44,365 66,335 C88,305 110,365 132,335 C154,305 176,365 198,335 C220,305 242,365 264,335"
                          stroke="#7c3aed" stroke-width="1.2" fill="none" opacity="0.07"/>

                    <!-- Sine / soundwave — right -->
                    <path d="M1176,215 C1198,185 1220,245 1242,215 C1264,185 1286,245 1308,215 C1330,185 1352,245 1374,215 C1396,185 1418,245 1440,215"
                          stroke="#7c3aed" stroke-width="1.2" fill="none" opacity="0.07"/>

                    <!-- EQ / frequency bars — bottom left -->
                    <g fill="#7c3aed" opacity="0.08">
                        <rect x="28"  y="620" width="5" height="20" rx="1"/>
                        <rect x="40"  y="608" width="5" height="32" rx="1"/>
                        <rect x="52"  y="600" width="5" height="40" rx="1"/>
                        <rect x="64"  y="594" width="5" height="46" rx="1"/>
                        <rect x="76"  y="612" width="5" height="28" rx="1"/>
                        <rect x="88"  y="604" width="5" height="36" rx="1"/>
                        <rect x="100" y="622" width="5" height="18" rx="1"/>
                        <rect x="112" y="607" width="5" height="33" rx="1"/>
                        <rect x="124" y="591" width="5" height="49" rx="1"/>
                        <rect x="136" y="615" width="5" height="25" rx="1"/>
                        <rect x="148" y="601" width="5" height="39" rx="1"/>
                    </g>

                    <!-- EQ / frequency bars — bottom right -->
                    <g fill="#7c3aed" opacity="0.08">
                        <rect x="1263" y="622" width="5" height="18" rx="1"/>
                        <rect x="1275" y="607" width="5" height="33" rx="1"/>
                        <rect x="1287" y="594" width="5" height="46" rx="1"/>
                        <rect x="1299" y="601" width="5" height="39" rx="1"/>
                        <rect x="1311" y="591" width="5" height="49" rx="1"/>
                        <rect x="1323" y="604" width="5" height="36" rx="1"/>
                        <rect x="1335" y="615" width="5" height="25" rx="1"/>
                        <rect x="1347" y="607" width="5" height="33" rx="1"/>
                        <rect x="1359" y="620" width="5" height="20" rx="1"/>
                        <rect x="1371" y="612" width="5" height="28" rx="1"/>
                        <rect x="1383" y="601" width="5" height="39" rx="1"/>
                    </g>
                </svg>
            </div>

            {{-- Hero content --}}
            <div class="relative z-10 mx-auto max-w-4xl px-6 py-28 text-center">
                <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-violet-200 bg-violet-50 px-4 py-1.5 text-sm text-violet-700">
                    <span class="h-2 w-2 rounded-full bg-violet-500"></span>
                    Every member is ID verified
                </div>
                <h1 class="mb-6 text-5xl font-bold leading-tight tracking-tight text-zinc-900 md:text-6xl">
                    Connect with verified<br class="hidden md:block" /> songwriters &amp; producers
                </h1>
                <p class="mx-auto mb-10 max-w-2xl text-lg text-zinc-500">
                    SongwriterLink is a professional networking platform for the music industry.
                    Real people, real credits, free messaging — built on trust from day one.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('onboarding.start') }}" class="rounded-lg bg-brand px-8 py-3 font-semibold text-white hover:bg-brand-dark transition">
                        Apply for membership
                    </a>
                    <a href="{{ route('members.index') }}" class="rounded-lg border border-zinc-200 px-8 py-3 font-semibold text-zinc-700 hover:border-zinc-300 hover:bg-zinc-50 transition">
                        Browse members
                    </a>
                </div>
            </div>
        </section>

        {{-- Trust pillars --}}
        <section class="border-t border-zinc-100 bg-zinc-50 py-16">
            <div class="mx-auto grid max-w-5xl grid-cols-1 gap-8 px-6 md:grid-cols-3">
                <div class="text-center">
                    <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-white border border-zinc-200 shadow-sm">
                        <svg class="h-6 w-6 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="mb-2 font-semibold text-zinc-900">ID Verified</h3>
                    <p class="text-sm text-zinc-500">Every member completes government ID verification via Stripe Identity. No fake profiles, no bots.</p>
                </div>
                <div class="text-center">
                    <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-white border border-zinc-200 shadow-sm">
                        <svg class="h-6 w-6 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </div>
                    <h3 class="mb-2 font-semibold text-zinc-900">Free Messaging</h3>
                    <p class="text-sm text-zinc-500">Message any verified member directly — no credits, no paywalls on communication, ever.</p>
                </div>
                <div class="text-center">
                    <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-white border border-zinc-200 shadow-sm">
                        <svg class="h-6 w-6 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="mb-2 font-semibold text-zinc-900">Real Opportunities</h3>
                    <p class="text-sm text-zinc-500">Post and apply to briefs for co-writes, sync placements, toplines, and session work.</p>
                </div>
            </div>
        </section>

        {{-- Who it's for --}}
        <section id="features" class="border-t border-zinc-100 py-20">
            <div class="mx-auto max-w-5xl px-6">
                <div class="mb-12 text-center">
                    <h2 class="text-3xl font-bold text-zinc-900">Built for music industry professionals</h2>
                    <p class="mt-3 text-zinc-500">Whether you write lyrics, compose scores, produce beats or represent talent — SongwriterLink is your professional home.</p>
                </div>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div class="flex gap-4 rounded-xl border border-zinc-200 p-5">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-violet-50 text-violet-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-zinc-900">Songwriters &amp; Lyricists</h3>
                            <p class="mt-1 text-sm text-zinc-500">Showcase your credits, upload demos, and connect with artists and publishers looking for your sound.</p>
                        </div>
                    </div>
                    <div class="flex gap-4 rounded-xl border border-zinc-200 p-5">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-violet-50 text-violet-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-zinc-900">Composers &amp; Producers</h3>
                            <p class="mt-1 text-sm text-zinc-500">Find co-writers and collaborators. Post briefs for specific projects and receive applications from verified talent.</p>
                        </div>
                    </div>
                    <div class="flex gap-4 rounded-xl border border-zinc-200 p-5">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-violet-50 text-violet-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-zinc-900">Publishers &amp; A&amp;R</h3>
                            <p class="mt-1 text-sm text-zinc-500">Search verified writers by genre and credits. Every profile is backed by a real, ID-checked person.</p>
                        </div>
                    </div>
                    <div class="flex gap-4 rounded-xl border border-zinc-200 p-5">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-violet-50 text-violet-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/></svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-zinc-900">Sync &amp; Film Composers</h3>
                            <p class="mt-1 text-sm text-zinc-500">Get discovered for sync briefs. Display your IMDB, PRS, and portfolio credits in one verified place.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- How it works --}}
        <section id="how-it-works" class="border-t border-zinc-100 bg-zinc-50 py-20">
            <div class="mx-auto max-w-5xl px-6">
                <div class="mb-12 text-center">
                    <h2 class="text-3xl font-bold text-zinc-900">How it works</h2>
                    <p class="mt-3 text-zinc-500">Membership takes about 10 minutes. After that, you're part of a trusted professional network.</p>
                </div>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
                    @php
                        $steps = [
                            ['num' => '1', 'title' => 'Apply', 'desc' => 'Choose your role, create your account, and pay the one-time £4 joining fee.'],
                            ['num' => '2', 'title' => 'Verify your ID', 'desc' => 'Complete a quick government ID check via Stripe Identity — takes about 2 minutes.'],
                            ['num' => '3', 'title' => 'Build your profile', 'desc' => 'Add your bio, genres, social links, portfolio, and a professional photo.'],
                            ['num' => '4', 'title' => 'Connect', 'desc' => 'Browse verified members, message collaborators, and post or apply to briefs.'],
                        ];
                    @endphp
                    @foreach($steps as $step)
                        <div class="relative text-center">
                            <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-violet-600 text-lg font-bold text-white">
                                {{ $step['num'] }}
                            </div>
                            <h3 class="mb-2 font-semibold text-zinc-900">{{ $step['title'] }}</h3>
                            <p class="text-sm text-zinc-500">{{ $step['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="mt-10 text-center">
                    <a href="{{ route('onboarding.start') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand px-8 py-3 font-semibold text-white hover:bg-brand-dark">
                        Start your application
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
        </section>

        {{-- Pricing --}}
        <section id="pricing" class="border-t border-zinc-100 py-20">
            <div class="mx-auto max-w-5xl px-6">
                <div class="mb-4 text-center">
                    <h2 class="text-3xl font-bold text-zinc-900">Simple, transparent pricing</h2>
                    <p class="mt-3 text-zinc-500">No subscriptions. Pay once for a fixed term, then choose to renew when it suits you.</p>
                </div>
                <p class="mb-10 text-center text-sm text-zinc-400">All paid plans require a one-time <strong class="text-zinc-600">£4 joining fee</strong> — waived when you sign up to Pro or Pro+.</p>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    {{-- Free --}}
                    <div class="flex flex-col rounded-xl border border-zinc-200 p-6">
                        <div class="mb-4">
                            <h3 class="text-lg font-bold text-zinc-900">Free</h3>
                            <div class="mt-2 text-3xl font-bold text-zinc-900">£0</div>
                            <p class="mt-1 text-sm text-zinc-500">+ £4 joining fee</p>
                        </div>
                        <ul class="mb-6 flex-1 space-y-2 text-sm text-zinc-600">
                            <li class="flex items-center gap-2"><svg class="h-4 w-4 text-violet-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Verified member profile</li>
                            <li class="flex items-center gap-2"><svg class="h-4 w-4 text-violet-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Free messaging</li>
                            <li class="flex items-center gap-2"><svg class="h-4 w-4 text-violet-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>3 portfolio uploads</li>
                            <li class="flex items-center gap-2"><svg class="h-4 w-4 text-violet-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Browse &amp; apply to briefs</li>
                            <li class="flex items-center gap-2 text-zinc-400"><span class="inline-block h-4 w-4 text-center leading-4">—</span>Post briefs (£7/post)</li>
                        </ul>
                        <a href="{{ route('onboarding.start') }}" class="block w-full rounded-lg border border-zinc-200 px-4 py-2.5 text-center text-sm font-semibold text-zinc-700 hover:border-zinc-300 hover:bg-zinc-50 transition">
                            Join free
                        </a>
                    </div>

                    {{-- Pro --}}
                    <div class="relative flex flex-col rounded-xl border-2 border-violet-400 bg-violet-50 p-6 shadow-md">
                        <div class="absolute -top-3 left-1/2 -translate-x-1/2 rounded-full bg-violet-600 px-3 py-0.5 text-xs font-semibold text-white">Most popular</div>
                        <div class="mb-4">
                            <h3 class="text-lg font-bold text-zinc-900">Pro</h3>
                            <div class="mt-2 flex items-baseline gap-1">
                                <span class="text-3xl font-bold text-zinc-900">£80</span>
                                <span class="text-sm text-zinc-500">/ year</span>
                            </div>
                            <p class="mt-1 text-sm text-zinc-500">or £45 / 6 months &middot; £25 / 3 months</p>
                        </div>
                        <ul class="mb-6 flex-1 space-y-2 text-sm text-zinc-600">
                            <li class="flex items-center gap-2"><svg class="h-4 w-4 text-violet-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Everything in Free</li>
                            <li class="flex items-center gap-2"><svg class="h-4 w-4 text-violet-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Unlimited portfolio uploads</li>
                            <li class="flex items-center gap-2"><svg class="h-4 w-4 text-violet-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Profile analytics</li>
                            <li class="flex items-center gap-2"><svg class="h-4 w-4 text-violet-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Search boost + verified badge</li>
                            <li class="flex items-center gap-2"><svg class="h-4 w-4 text-violet-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Credits page &amp; CV export</li>
                            <li class="flex items-center gap-2"><svg class="h-4 w-4 text-violet-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Split sheet generator</li>
                        </ul>
                        <a href="{{ route('onboarding.start') }}" class="block w-full rounded-lg bg-violet-600 px-4 py-2.5 text-center text-sm font-semibold text-white hover:bg-violet-700 transition">
                            Get Pro
                        </a>
                    </div>

                    {{-- Pro+ --}}
                    <div class="flex flex-col rounded-xl border border-zinc-200 p-6">
                        <div class="mb-4">
                            <h3 class="text-lg font-bold text-zinc-900">Pro+</h3>
                            <div class="mt-2 flex items-baseline gap-1">
                                <span class="text-3xl font-bold text-zinc-900">£180</span>
                                <span class="text-sm text-zinc-500">/ year</span>
                            </div>
                            <p class="mt-1 text-sm text-zinc-500">or £100 / 6 months &middot; £55 / 3 months</p>
                        </div>
                        <ul class="mb-6 flex-1 space-y-2 text-sm text-zinc-600">
                            <li class="flex items-center gap-2"><svg class="h-4 w-4 text-violet-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Everything in Pro</li>
                            <li class="flex items-center gap-2"><svg class="h-4 w-4 text-violet-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Up to 5 open briefs at once</li>
                            <li class="flex items-center gap-2"><svg class="h-4 w-4 text-violet-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Free brief posting (saves £7/post)</li>
                            <li class="flex items-center gap-2"><svg class="h-4 w-4 text-violet-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>View member social links</li>
                            <li class="flex items-center gap-2"><svg class="h-4 w-4 text-violet-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Instant application alerts</li>
                            <li class="flex items-center gap-2"><svg class="h-4 w-4 text-violet-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Promoted profile (1 per term)</li>
                        </ul>
                        <a href="{{ route('onboarding.start') }}" class="block w-full rounded-lg border border-zinc-200 px-4 py-2.5 text-center text-sm font-semibold text-zinc-700 hover:border-violet-300 hover:bg-violet-50 transition">
                            Get Pro+
                        </a>
                    </div>
                </div>

                <p class="mt-8 text-center text-xs text-zinc-400">
                    All payments handled securely by Stripe. No recurring billing — you choose when to renew.
                    <a href="{{ route('onboarding.step', 8) }}" class="ml-1 text-violet-600 hover:underline">See full feature comparison →</a>
                </p>
            </div>
        </section>

        {{-- Trust / closing CTA --}}
        <section class="border-t border-zinc-100 bg-zinc-50 py-16">
            <div class="mx-auto max-w-2xl px-6 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-violet-100">
                    <svg class="h-7 w-7 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </div>
                <h2 class="mb-4 text-2xl font-bold text-zinc-900">Built by songwriters, for songwriters</h2>
                <p class="mb-6 text-zinc-500">
                    We built SongwriterLink because we got tired of platforms full of fake profiles and cold-message spam.
                    The ID verification requirement isn't a hurdle — it's the feature. It's why every connection you make here is worth making.
                </p>
                <a href="{{ route('onboarding.start') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand px-8 py-3 font-semibold text-white hover:bg-brand-dark">
                    Apply for membership
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </section>

        {{-- Footer --}}
        <footer class="border-t border-zinc-100 py-8 text-center text-sm text-zinc-400">
            <p>&copy; {{ date('Y') }} SongwriterLink. <a href="{{ route('privacy') }}" class="hover:text-zinc-600">Privacy</a> &middot; <a href="{{ route('terms') }}" class="hover:text-zinc-600">Terms</a></p>
        </footer>

        @fluxScripts
    </body>
</html>
