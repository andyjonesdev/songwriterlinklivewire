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

                    <!-- Background glow -->
                    <rect width="1440" height="660" fill="url(#heroGlow)"/>

                    <!-- Connection edges -->
                    <g stroke="#7c3aed" stroke-width="0.8" opacity="0.18">
                        <line x1="100"  y1="210" x2="265"  y2="155"/>
                        <line x1="265"  y1="155" x2="445"  y2="235"/>
                        <line x1="100"  y1="210" x2="315"  y2="375"/>
                        <line x1="315"  y1="375" x2="445"  y2="235"/>
                        <line x1="445"  y1="235" x2="645"  y2="175"/>
                        <line x1="445"  y1="235" x2="585"  y2="415"/>
                        <line x1="645"  y1="175" x2="825"  y2="125"/>
                        <line x1="645"  y1="175" x2="762"  y2="302"/>
                        <line x1="762"  y1="302" x2="945"  y2="375"/>
                        <line x1="825"  y1="125" x2="985"  y2="185"/>
                        <line x1="985"  y1="185" x2="1165" y2="145"/>
                        <line x1="985"  y1="185" x2="1082" y2="322"/>
                        <line x1="1082" y1="322" x2="1305" y2="275"/>
                        <line x1="1165" y1="145" x2="1305" y2="275"/>
                        <line x1="315"  y1="375" x2="585"  y2="415"/>
                        <line x1="585"  y1="415" x2="762"  y2="302"/>
                        <line x1="945"  y1="375" x2="1082" y2="322"/>
                        <line x1="90"   y1="455" x2="315"  y2="375"/>
                        <line x1="1305" y1="275" x2="1385" y2="440"/>
                        <line x1="1385" y1="195" x2="1165" y2="145"/>
                        <line x1="1385" y1="195" x2="1305" y2="275"/>
                        <line x1="265"  y1="155" x2="100"  y2="210"/>
                    </g>

                    <!-- Small music notes sitting on edges (quarter notes, UP or DOWN) -->
                    <!-- A→B midpoint (182,182) UP -->
                    <g fill="#7c3aed" opacity="0.42">
                        <ellipse cx="182" cy="182" rx="3.5" ry="2.5" transform="rotate(-20 182 182)"/>
                        <line x1="185" y1="181" x2="185" y2="169" stroke="#7c3aed" stroke-width="1.2"/>
                    </g>
                    <!-- C→E midpoint (545,205) UP -->
                    <g fill="#7c3aed" opacity="0.42">
                        <ellipse cx="545" cy="205" rx="3.5" ry="2.5" transform="rotate(-20 545 205)"/>
                        <line x1="548" y1="204" x2="548" y2="192" stroke="#7c3aed" stroke-width="1.2"/>
                    </g>
                    <!-- F→I midpoint (905,155) DOWN -->
                    <g fill="#7c3aed" opacity="0.38">
                        <ellipse cx="905" cy="155" rx="3.5" ry="2.5" transform="rotate(-20 905 155)"/>
                        <line x1="902" y1="156" x2="902" y2="168" stroke="#7c3aed" stroke-width="1.2"/>
                    </g>
                    <!-- E→G midpoint (703,238) DOWN -->
                    <g fill="#7c3aed" opacity="0.40">
                        <ellipse cx="703" cy="238" rx="3.5" ry="2.5" transform="rotate(-20 703 238)"/>
                        <line x1="700" y1="239" x2="700" y2="251" stroke="#7c3aed" stroke-width="1.2"/>
                    </g>
                    <!-- I→K midpoint (1075,165) UP -->
                    <g fill="#7c3aed" opacity="0.40">
                        <ellipse cx="1075" cy="165" rx="3.5" ry="2.5" transform="rotate(-20 1075 165)"/>
                        <line x1="1078" y1="164" x2="1078" y2="152" stroke="#7c3aed" stroke-width="1.2"/>
                    </g>
                    <!-- G→H midpoint (853,338) UP -->
                    <g fill="#7c3aed" opacity="0.38">
                        <ellipse cx="853" cy="338" rx="3.5" ry="2.5" transform="rotate(-20 853 338)"/>
                        <line x1="856" y1="337" x2="856" y2="325" stroke="#7c3aed" stroke-width="1.2"/>
                    </g>
                    <!-- J→L midpoint (1193,298) DOWN -->
                    <g fill="#7c3aed" opacity="0.38">
                        <ellipse cx="1193" cy="298" rx="3.5" ry="2.5" transform="rotate(-20 1193 298)"/>
                        <line x1="1190" y1="299" x2="1190" y2="311" stroke="#7c3aed" stroke-width="1.2"/>
                    </g>
                    <!-- D→M midpoint (450,395) UP -->
                    <g fill="#7c3aed" opacity="0.38">
                        <ellipse cx="450" cy="395" rx="3.5" ry="2.5" transform="rotate(-20 450 395)"/>
                        <line x1="453" y1="394" x2="453" y2="382" stroke="#7c3aed" stroke-width="1.2"/>
                    </g>

                    <!-- Circular nodes -->
                    <g fill="#7c3aed">
                        <circle cx="100"  cy="210" r="5.5" opacity="0.35"/>
                        <circle cx="265"  cy="155" r="6.5" opacity="0.45"/>
                        <circle cx="445"  cy="235" r="8.5" opacity="0.60"/>
                        <circle cx="315"  cy="375" r="5.5" opacity="0.38"/>
                        <circle cx="645"  cy="175" r="6.5" opacity="0.48"/>
                        <circle cx="825"  cy="125" r="5.5" opacity="0.34"/>
                        <circle cx="762"  cy="302" r="8"   opacity="0.55"/>
                        <circle cx="945"  cy="375" r="5.5" opacity="0.38"/>
                        <circle cx="985"  cy="185" r="8.5" opacity="0.60"/>
                        <circle cx="1082" cy="322" r="6.5" opacity="0.45"/>
                        <circle cx="1165" cy="145" r="6"   opacity="0.46"/>
                        <circle cx="1305" cy="275" r="7"   opacity="0.48"/>
                        <circle cx="585"  cy="415" r="5"   opacity="0.36"/>
                        <circle cx="90"   cy="455" r="5"   opacity="0.32"/>
                        <circle cx="1385" cy="195" r="5"   opacity="0.35"/>
                        <circle cx="1385" cy="440" r="4.5" opacity="0.30"/>
                    </g>

                    <!-- Pulse rings on hub nodes C(445,235), G(762,302), I(985,185) -->
                    <g fill="none" stroke="#7c3aed" stroke-width="1.2">
                        <circle cx="445" cy="235" r="9">
                            <animate attributeName="r"       values="9;27"   dur="3.5s" repeatCount="indefinite"/>
                            <animate attributeName="opacity" values="0.45;0" dur="3.5s" repeatCount="indefinite"/>
                        </circle>
                        <circle cx="985" cy="185" r="9">
                            <animate attributeName="r"       values="9;27"   dur="3.5s" begin="1.2s" repeatCount="indefinite"/>
                            <animate attributeName="opacity" values="0.45;0" dur="3.5s" begin="1.2s" repeatCount="indefinite"/>
                        </circle>
                        <circle cx="762" cy="302" r="9">
                            <animate attributeName="r"       values="9;27"   dur="3.5s" begin="2.4s" repeatCount="indefinite"/>
                            <animate attributeName="opacity" values="0.45;0" dur="3.5s" begin="2.4s" repeatCount="indefinite"/>
                        </circle>
                    </g>

                    <!-- Audio waveform — 13 parallel sine curves with envelope amplitude -->
                    <!-- Period=180px, 8 cycles across 1440. Centre y≈567, band y=537–597 -->
                    <g stroke="#7c3aed" fill="none" opacity="0.09">
                        <path stroke-width="0.8" d="M0,537 C45,533 135,533 180,537 C225,541 315,541 360,537 C405,533 495,533 540,537 C585,541 675,541 720,537 C765,533 855,533 900,537 C945,541 1035,541 1080,537 C1125,533 1215,533 1260,537 C1305,541 1395,541 1440,537"/>
                        <path stroke-width="0.9" d="M0,542 C45,535 135,535 180,542 C225,549 315,549 360,542 C405,535 495,535 540,542 C585,549 675,549 720,542 C765,535 855,535 900,542 C945,549 1035,549 1080,542 C1125,535 1215,535 1260,542 C1305,549 1395,549 1440,542"/>
                        <path stroke-width="1"   d="M0,547 C45,537 135,537 180,547 C225,557 315,557 360,547 C405,537 495,537 540,547 C585,557 675,557 720,547 C765,537 855,537 900,547 C945,557 1035,557 1080,547 C1125,537 1215,537 1260,547 C1305,557 1395,557 1440,547"/>
                        <path stroke-width="1"   d="M0,552 C45,540 135,540 180,552 C225,564 315,564 360,552 C405,540 495,540 540,552 C585,564 675,564 720,552 C765,540 855,540 900,552 C945,564 1035,564 1080,552 C1125,540 1215,540 1260,552 C1305,564 1395,564 1440,552"/>
                        <path stroke-width="1.1" d="M0,557 C45,543 135,543 180,557 C225,571 315,571 360,557 C405,543 495,543 540,557 C585,571 675,571 720,557 C765,543 855,543 900,557 C945,571 1035,571 1080,557 C1125,543 1215,543 1260,557 C1305,571 1395,571 1440,557"/>
                        <path stroke-width="1.2" d="M0,562 C45,547 135,547 180,562 C225,577 315,577 360,562 C405,547 495,547 540,562 C585,577 675,577 720,562 C765,547 855,547 900,562 C945,577 1035,577 1080,562 C1125,547 1215,547 1260,562 C1305,577 1395,577 1440,562"/>
                        <path stroke-width="1.3" d="M0,567 C45,552 135,552 180,567 C225,582 315,582 360,567 C405,552 495,552 540,567 C585,582 675,582 720,567 C765,552 855,552 900,567 C945,582 1035,582 1080,567 C1125,552 1215,552 1260,567 C1305,582 1395,582 1440,567"/>
                        <path stroke-width="1.3" d="M0,572 C45,557 135,557 180,572 C225,587 315,587 360,572 C405,557 495,557 540,572 C585,587 675,587 720,572 C765,557 855,557 900,572 C945,587 1035,587 1080,572 C1125,557 1215,557 1260,572 C1305,587 1395,587 1440,572"/>
                        <path stroke-width="1.2" d="M0,577 C45,563 135,563 180,577 C225,591 315,591 360,577 C405,563 495,563 540,577 C585,591 675,591 720,577 C765,563 855,563 900,577 C945,591 1035,591 1080,577 C1125,563 1215,563 1260,577 C1305,591 1395,591 1440,577"/>
                        <path stroke-width="1.1" d="M0,582 C45,570 135,570 180,582 C225,594 315,594 360,582 C405,570 495,570 540,582 C585,594 675,594 720,582 C765,570 855,570 900,582 C945,594 1035,594 1080,582 C1125,570 1215,570 1260,582 C1305,594 1395,594 1440,582"/>
                        <path stroke-width="1"   d="M0,587 C45,577 135,577 180,587 C225,597 315,597 360,587 C405,577 495,577 540,587 C585,597 675,597 720,587 C765,577 855,577 900,587 C945,597 1035,597 1080,587 C1125,577 1215,577 1260,587 C1305,597 1395,597 1440,587"/>
                        <path stroke-width="0.9" d="M0,592 C45,585 135,585 180,592 C225,599 315,599 360,592 C405,585 495,585 540,592 C585,599 675,599 720,592 C765,585 855,585 900,592 C945,599 1035,599 1080,592 C1125,585 1215,585 1260,592 C1305,599 1395,599 1440,592"/>
                        <path stroke-width="0.8" d="M0,597 C45,593 135,593 180,597 C225,601 315,601 360,597 C405,593 495,593 540,597 C585,601 675,601 720,597 C765,593 855,593 900,597 C945,601 1035,601 1080,597 C1125,593 1215,593 1260,597 C1305,601 1395,601 1440,597"/>
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
