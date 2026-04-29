<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
        <title>SongwriterLink — Where Songwriters Connect</title>
    </head>
    <body class="min-h-screen bg-white font-sans text-zinc-900">

        {{-- ── Nav ──────────────────────────────────────────────────────────────── --}}
        <nav class="sticky top-0 z-30 border-b border-zinc-100 bg-white/95 backdrop-blur">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
                <a href="/" class="flex items-center gap-2">
                    <img src="/storage/songwriterlink_logo.png" alt="SongwriterLink" class="h-8 w-auto" />
                    <span class="text-base font-semibold text-zinc-900">SongwriterLink</span>
                </a>
                <div class="hidden items-center gap-8 md:flex">
                    <a href="#trust"      class="text-sm text-zinc-500 hover:text-zinc-900 transition">Trust</a>
                    <a href="#features"   class="text-sm text-zinc-500 hover:text-zinc-900 transition">Features</a>
                    <a href="#how"        class="text-sm text-zinc-500 hover:text-zinc-900 transition">How it works</a>
                    <a href="#pricing"    class="text-sm text-zinc-500 hover:text-zinc-900 transition">Pricing</a>
                </div>
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm text-zinc-500 hover:text-zinc-900">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-zinc-500 hover:text-zinc-900">Sign in</a>
                        <a href="{{ route('onboarding.start') }}" class="rounded-lg bg-brand px-4 py-2 text-sm font-semibold text-white hover:bg-brand-dark transition">
                            Join free
                        </a>
                    @endauth
                </div>
            </div>
        </nav>

        {{-- ── Hero ─────────────────────────────────────────────────────────────── --}}
        <section class="relative overflow-hidden bg-white">

            <div class="absolute inset-0">
                <svg viewBox="0 0 1440 640" preserveAspectRatio="xMidYMid slice"
                     class="h-full w-full" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <radialGradient id="heroGlow" cx="50%" cy="42%" r="48%">
                            <stop offset="0%"   stop-color="#7c3aed" stop-opacity="0.05"/>
                            <stop offset="100%" stop-color="#7c3aed" stop-opacity="0"/>
                        </radialGradient>
                    </defs>

                    <!-- Background glow -->
                    <rect width="1440" height="640" fill="url(#heroGlow)"/>

                    <!-- Connection network edges -->
                    <g stroke="#7c3aed" stroke-width="0.8" opacity="0.16">
                        <line x1="100"  y1="180" x2="265"  y2="130"/>
                        <line x1="265"  y1="130" x2="445"  y2="210"/>
                        <line x1="100"  y1="180" x2="315"  y2="345"/>
                        <line x1="315"  y1="345" x2="445"  y2="210"/>
                        <line x1="445"  y1="210" x2="645"  y2="155"/>
                        <line x1="445"  y1="210" x2="585"  y2="385"/>
                        <line x1="645"  y1="155" x2="825"  y2="105"/>
                        <line x1="645"  y1="155" x2="762"  y2="278"/>
                        <line x1="762"  y1="278" x2="945"  y2="350"/>
                        <line x1="825"  y1="105" x2="985"  y2="162"/>
                        <line x1="985"  y1="162" x2="1165" y2="122"/>
                        <line x1="985"  y1="162" x2="1082" y2="298"/>
                        <line x1="1082" y1="298" x2="1305" y2="252"/>
                        <line x1="1165" y1="122" x2="1305" y2="252"/>
                        <line x1="315"  y1="345" x2="585"  y2="385"/>
                        <line x1="585"  y1="385" x2="762"  y2="278"/>
                        <line x1="945"  y1="350" x2="1082" y2="298"/>
                        <line x1="90"   y1="428" x2="315"  y2="345"/>
                        <line x1="1305" y1="252" x2="1385" y2="415"/>
                        <line x1="1385" y1="172" x2="1165" y2="122"/>
                        <line x1="1385" y1="172" x2="1305" y2="252"/>
                    </g>

                    <!-- Nodes -->
                    <g fill="#7c3aed">
                        <circle cx="100"  cy="180" r="5"   opacity="0.32"/>
                        <circle cx="265"  cy="130" r="6"   opacity="0.42"/>
                        <circle cx="445"  cy="210" r="8"   opacity="0.58"/>
                        <circle cx="315"  cy="345" r="5"   opacity="0.35"/>
                        <circle cx="645"  cy="155" r="6"   opacity="0.45"/>
                        <circle cx="825"  cy="105" r="5"   opacity="0.32"/>
                        <circle cx="762"  cy="278" r="7.5" opacity="0.52"/>
                        <circle cx="945"  cy="350" r="5"   opacity="0.35"/>
                        <circle cx="985"  cy="162" r="8"   opacity="0.58"/>
                        <circle cx="1082" cy="298" r="6"   opacity="0.42"/>
                        <circle cx="1165" cy="122" r="5.5" opacity="0.44"/>
                        <circle cx="1305" cy="252" r="6.5" opacity="0.46"/>
                        <circle cx="585"  cy="385" r="4.5" opacity="0.33"/>
                        <circle cx="90"   cy="428" r="4.5" opacity="0.30"/>
                        <circle cx="1385" cy="172" r="4.5" opacity="0.32"/>
                        <circle cx="1385" cy="415" r="4"   opacity="0.28"/>
                    </g>

                    <!-- Pulse rings on three hub nodes -->
                    <g fill="none" stroke="#7c3aed" stroke-width="1.2">
                        <circle cx="445" cy="210" r="8">
                            <animate attributeName="r"       values="8;28"   dur="3.5s" repeatCount="indefinite"/>
                            <animate attributeName="opacity" values="0.42;0" dur="3.5s" repeatCount="indefinite"/>
                        </circle>
                        <circle cx="985" cy="162" r="8">
                            <animate attributeName="r"       values="8;28"   dur="3.5s" begin="1.2s" repeatCount="indefinite"/>
                            <animate attributeName="opacity" values="0.42;0" dur="3.5s" begin="1.2s" repeatCount="indefinite"/>
                        </circle>
                        <circle cx="762" cy="278" r="8">
                            <animate attributeName="r"       values="8;28"   dur="3.5s" begin="2.4s" repeatCount="indefinite"/>
                            <animate attributeName="opacity" values="0.42;0" dur="3.5s" begin="2.4s" repeatCount="indefinite"/>
                        </circle>
                    </g>

                    <!-- ── Waveforms — 20 sine curves, amplitude envelope peaks at centre ── -->
                    <g stroke="#7c3aed" fill="none">
                        <path stroke-width="0.6" opacity="0.06" d="M0,500 C45,497 135,497 180,500 C225,503 315,503 360,500 C405,497 495,497 540,500 C585,503 675,503 720,500 C765,497 855,497 900,500 C945,503 1035,503 1080,500 C1125,497 1215,497 1260,500 C1305,503 1395,503 1440,500"/>
                        <path stroke-width="0.7" opacity="0.07" d="M0,506 C45,501 135,501 180,506 C225,511 315,511 360,506 C405,501 495,501 540,506 C585,511 675,511 720,506 C765,501 855,501 900,506 C945,511 1035,511 1080,506 C1125,501 1215,501 1260,506 C1305,511 1395,511 1440,506"/>
                        <path stroke-width="0.8" opacity="0.08" d="M0,513 C45,506 135,506 180,513 C225,520 315,520 360,513 C405,506 495,506 540,513 C585,520 675,520 720,513 C765,506 855,506 900,513 C945,520 1035,520 1080,513 C1125,506 1215,506 1260,513 C1305,520 1395,520 1440,513"/>
                        <path stroke-width="0.9" opacity="0.08" d="M0,520 C45,511 135,511 180,520 C225,529 315,529 360,520 C405,511 495,511 540,520 C585,529 675,529 720,520 C765,511 855,511 900,520 C945,529 1035,529 1080,520 C1125,511 1215,511 1260,520 C1305,529 1395,529 1440,520"/>
                        <path stroke-width="1.0" opacity="0.09" d="M0,528 C45,517 135,517 180,528 C225,539 315,539 360,528 C405,517 495,517 540,528 C585,539 675,539 720,528 C765,517 855,517 900,528 C945,539 1035,539 1080,528 C1125,517 1215,517 1260,528 C1305,539 1395,539 1440,528"/>
                        <path stroke-width="1.0" opacity="0.09" d="M0,535 C45,522 135,522 180,535 C225,548 315,548 360,535 C405,522 495,522 540,535 C585,548 675,548 720,535 C765,522 855,522 900,535 C945,548 1035,548 1080,535 C1125,522 1215,522 1260,535 C1305,548 1395,548 1440,535"/>
                        <path stroke-width="1.1" opacity="0.09" d="M0,543 C45,528 135,528 180,543 C225,558 315,558 360,543 C405,528 495,528 540,543 C585,558 675,558 720,543 C765,528 855,528 900,543 C945,558 1035,558 1080,543 C1125,528 1215,528 1260,543 C1305,558 1395,558 1440,543"/>
                        <path stroke-width="1.2" opacity="0.10" d="M0,551 C45,534 135,534 180,551 C225,568 315,568 360,551 C405,534 495,534 540,551 C585,568 675,568 720,551 C765,534 855,534 900,551 C945,568 1035,568 1080,551 C1125,534 1215,534 1260,551 C1305,568 1395,568 1440,551"/>
                        <!-- Central widest lines — notes sit on these peaks -->
                        <path stroke-width="1.4" opacity="0.10" d="M0,559 C45,540 135,540 180,559 C225,578 315,578 360,559 C405,540 495,540 540,559 C585,578 675,578 720,559 C765,540 855,540 900,559 C945,578 1035,578 1080,559 C1125,540 1215,540 1260,559 C1305,578 1395,578 1440,559"/>
                        <path stroke-width="1.4" opacity="0.10" d="M0,567 C45,548 135,548 180,567 C225,586 315,586 360,567 C405,548 495,548 540,567 C585,586 675,586 720,567 C765,548 855,548 900,567 C945,586 1035,586 1080,567 C1125,548 1215,548 1260,567 C1305,586 1395,586 1440,567"/>
                        <path stroke-width="1.2" opacity="0.10" d="M0,575 C45,558 135,558 180,575 C225,592 315,592 360,575 C405,558 495,558 540,575 C585,592 675,592 720,575 C765,558 855,558 900,575 C945,592 1035,592 1080,575 C1125,558 1215,558 1260,575 C1305,592 1395,592 1440,575"/>
                        <path stroke-width="1.1" opacity="0.09" d="M0,583 C45,568 135,568 180,583 C225,598 315,598 360,583 C405,568 495,568 540,583 C585,598 675,598 720,583 C765,568 855,568 900,583 C945,598 1035,598 1080,583 C1125,568 1215,568 1260,583 C1305,598 1395,598 1440,583"/>
                        <path stroke-width="1.0" opacity="0.09" d="M0,590 C45,577 135,577 180,590 C225,603 315,603 360,590 C405,577 495,577 540,590 C585,603 675,603 720,590 C765,577 855,577 900,590 C945,603 1035,603 1080,590 C1125,577 1215,577 1260,590 C1305,603 1395,603 1440,590"/>
                        <path stroke-width="0.9" opacity="0.09" d="M0,597 C45,586 135,586 180,597 C225,608 315,608 360,597 C405,586 495,586 540,597 C585,608 675,608 720,597 C765,586 855,586 900,597 C945,608 1035,608 1080,597 C1125,586 1215,586 1260,597 C1305,608 1395,608 1440,597"/>
                        <path stroke-width="0.8" opacity="0.08" d="M0,604 C45,595 135,595 180,604 C225,613 315,613 360,604 C405,595 495,595 540,604 C585,613 675,613 720,604 C765,595 855,595 900,604 C945,613 1035,613 1080,604 C1125,595 1215,595 1260,604 C1305,613 1395,613 1440,604"/>
                        <path stroke-width="0.8" opacity="0.08" d="M0,610 C45,603 135,603 180,610 C225,617 315,617 360,610 C405,603 495,603 540,610 C585,617 675,617 720,610 C765,603 855,603 900,610 C945,617 1035,617 1080,610 C1125,603 1215,603 1260,610 C1305,617 1395,617 1440,610"/>
                        <path stroke-width="0.7" opacity="0.07" d="M0,616 C45,611 135,611 180,616 C225,621 315,621 360,616 C405,611 495,611 540,616 C585,621 675,621 720,616 C765,611 855,611 900,616 C945,621 1035,621 1080,616 C1125,611 1215,611 1260,616 C1305,621 1395,621 1440,616"/>
                        <path stroke-width="0.6" opacity="0.07" d="M0,621 C45,617 135,617 180,621 C225,625 315,625 360,621 C405,617 495,617 540,621 C585,625 675,625 720,621 C765,617 855,617 900,621 C945,625 1035,625 1080,621 C1125,617 1215,617 1260,621 C1305,625 1395,625 1440,621"/>
                        <path stroke-width="0.6" opacity="0.06" d="M0,626 C45,623 135,623 180,626 C225,629 315,629 360,626 C405,623 495,623 540,626 C585,629 675,629 720,626 C765,623 855,623 900,626 C945,629 1035,629 1080,626 C1125,623 1215,623 1260,626 C1305,629 1395,629 1440,626"/>
                        <path stroke-width="0.5" opacity="0.05" d="M0,630 C45,628 135,628 180,630 C225,632 315,632 360,630 C405,628 495,628 540,630 C585,632 675,632 720,630 C765,628 855,628 900,630 C945,632 1035,632 1080,630 C1125,628 1215,628 1260,630 C1305,632 1395,632 1440,630"/>
                    </g>

                    <!-- ── Eighth notes (beamed pairs) at wave peaks — x=90,450,810,1170 ── -->
                    <!-- Wave 9 peaks at y=540. Note heads sit on peak, stems rise 22px. -->
                    <g opacity="0.13">
                        <!-- Beamed pair — peak x=90 -->
                        <g transform="translate(81,540)">
                            <ellipse cx="0"  cy="0" rx="5.5" ry="3.8" fill="#7c3aed" stroke="none" transform="rotate(-25 0 0)"/>
                            <line x1="4.8" y1="-1"  x2="4.8"  y2="-22" stroke="#7c3aed" stroke-width="1.5"/>
                            <ellipse cx="16" cy="0" rx="5.5" ry="3.8" fill="#7c3aed" stroke="none" transform="rotate(-25 16 0)"/>
                            <line x1="20.8" y1="-1" x2="20.8" y2="-22" stroke="#7c3aed" stroke-width="1.5"/>
                            <rect x="4.3" y="-23.5" width="17" height="3" rx="1" fill="#7c3aed" stroke="none"/>
                        </g>
                        <!-- Beamed pair — peak x=450 -->
                        <g transform="translate(441,540)">
                            <ellipse cx="0"  cy="0" rx="5.5" ry="3.8" fill="#7c3aed" stroke="none" transform="rotate(-25 0 0)"/>
                            <line x1="4.8" y1="-1"  x2="4.8"  y2="-22" stroke="#7c3aed" stroke-width="1.5"/>
                            <ellipse cx="16" cy="0" rx="5.5" ry="3.8" fill="#7c3aed" stroke="none" transform="rotate(-25 16 0)"/>
                            <line x1="20.8" y1="-1" x2="20.8" y2="-22" stroke="#7c3aed" stroke-width="1.5"/>
                            <rect x="4.3" y="-23.5" width="17" height="3" rx="1" fill="#7c3aed" stroke="none"/>
                        </g>
                        <!-- Beamed pair — peak x=810 -->
                        <g transform="translate(801,540)">
                            <ellipse cx="0"  cy="0" rx="5.5" ry="3.8" fill="#7c3aed" stroke="none" transform="rotate(-25 0 0)"/>
                            <line x1="4.8" y1="-1"  x2="4.8"  y2="-22" stroke="#7c3aed" stroke-width="1.5"/>
                            <ellipse cx="16" cy="0" rx="5.5" ry="3.8" fill="#7c3aed" stroke="none" transform="rotate(-25 16 0)"/>
                            <line x1="20.8" y1="-1" x2="20.8" y2="-22" stroke="#7c3aed" stroke-width="1.5"/>
                            <rect x="4.3" y="-23.5" width="17" height="3" rx="1" fill="#7c3aed" stroke="none"/>
                        </g>
                        <!-- Beamed pair — peak x=1170 -->
                        <g transform="translate(1161,540)">
                            <ellipse cx="0"  cy="0" rx="5.5" ry="3.8" fill="#7c3aed" stroke="none" transform="rotate(-25 0 0)"/>
                            <line x1="4.8" y1="-1"  x2="4.8"  y2="-22" stroke="#7c3aed" stroke-width="1.5"/>
                            <ellipse cx="16" cy="0" rx="5.5" ry="3.8" fill="#7c3aed" stroke="none" transform="rotate(-25 16 0)"/>
                            <line x1="20.8" y1="-1" x2="20.8" y2="-22" stroke="#7c3aed" stroke-width="1.5"/>
                            <rect x="4.3" y="-23.5" width="17" height="3" rx="1" fill="#7c3aed" stroke="none"/>
                        </g>
                        <!-- Single eighth notes on wave 6 (peak y=522) at offset x positions -->
                        <!-- x=270 is a trough; place singles at x=630 on shallower wave (y=535,a=13 → peak=522) -->
                        <g transform="translate(626,522)">
                            <ellipse cx="0" cy="0" rx="5" ry="3.4" fill="#7c3aed" stroke="none" transform="rotate(-25 0 0)"/>
                            <line x1="4.3" y1="-1" x2="4.3" y2="-19" stroke="#7c3aed" stroke-width="1.4"/>
                            <path d="M4.3,-19 C13,-16 13,-10 4.3,-13" stroke="#7c3aed" stroke-width="1.4" fill="none" stroke-linecap="round"/>
                        </g>
                        <g transform="translate(986,522)">
                            <ellipse cx="0" cy="0" rx="5" ry="3.4" fill="#7c3aed" stroke="none" transform="rotate(-25 0 0)"/>
                            <line x1="4.3" y1="-1" x2="4.3" y2="-19" stroke="#7c3aed" stroke-width="1.4"/>
                            <path d="M4.3,-19 C13,-16 13,-10 4.3,-13" stroke="#7c3aed" stroke-width="1.4" fill="none" stroke-linecap="round"/>
                        </g>
                    </g>

                </svg>
            </div>

            {{-- Hero content --}}
            <div class="relative z-10 mx-auto max-w-4xl px-6 py-28 text-center">
                <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-violet-200 bg-violet-50 px-4 py-1.5 text-sm font-medium text-violet-700">
                    <span class="h-1.5 w-1.5 rounded-full bg-violet-500"></span>
                    Free to join · ID-verified community
                </div>
                <h1 class="mb-6 text-5xl font-bold leading-tight tracking-tight text-zinc-900 md:text-6xl">
                    Find your people.<br class="hidden md:block" /> Make better music.
                </h1>
                <p class="mx-auto mb-10 max-w-2xl text-lg text-zinc-500">
                    SongwriterLink brings together songwriters, lyricists, composers, producers and topliners —
                    whether you're just starting out or have decades of credits. Free to join, free to message, genuinely safe.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('onboarding.start') }}" class="rounded-lg bg-brand px-8 py-3 font-semibold text-white hover:bg-brand-dark transition">
                        Join the community
                    </a>
                    <a href="{{ route('members.index') }}" class="rounded-lg border border-zinc-200 px-8 py-3 font-semibold text-zinc-700 hover:border-zinc-300 hover:bg-zinc-50 transition">
                        Browse members
                    </a>
                </div>
            </div>
        </section>

        {{-- ── Trust pillars ─────────────────────────────────────────────────────── --}}
        <section id="trust" class="border-t border-zinc-100">
            <div class="mx-auto max-w-7xl">

                {{-- Section header --}}
                <div class="border-b border-zinc-100 px-6 py-10 md:px-10 md:py-12">
                    <p class="mb-3 flex items-center gap-2.5 text-xs font-semibold uppercase tracking-widest text-violet-600">
                        <span class="inline-block h-px w-6 bg-violet-400"></span>
                        Why it works
                    </p>
                    <h2 class="text-2xl font-bold text-zinc-900 md:text-3xl">A community you can actually trust</h2>
                    <p class="mt-2 max-w-xl text-zinc-500">Every member is a real person with a verified identity. That changes the whole feel — conversations are genuine, connections are meaningful, and you never have to wonder who you're talking to.</p>
                </div>

                {{-- 3-col grid --}}
                <div class="grid md:grid-cols-3">
                    <div class="border-b p-8 md:border-b-0 md:border-r md:p-10 border-zinc-100">
                        <div class="mb-5 flex h-10 w-10 items-center justify-center rounded-lg border border-zinc-200 bg-white">
                            <svg class="h-5 w-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-zinc-900">Real people only</h3>
                        <p class="text-sm leading-relaxed text-zinc-500">Every member completes a quick government ID check. No bots, no fake accounts — just real songwriters and music makers like you.</p>
                    </div>
                    <div class="border-b p-8 md:border-b-0 md:border-r md:p-10 border-zinc-100">
                        <div class="mb-5 flex h-10 w-10 items-center justify-center rounded-lg border border-zinc-200 bg-white">
                            <svg class="h-5 w-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-zinc-900">Message anyone, free</h3>
                        <p class="text-sm leading-relaxed text-zinc-500">Reach out to any member directly — no credits, no tokens, no paywalls. If you want to collaborate, just say hello.</p>
                    </div>
                    <div class="p-8 md:p-10">
                        <div class="mb-5 flex h-10 w-10 items-center justify-center rounded-lg border border-zinc-200 bg-white">
                            <svg class="h-5 w-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-zinc-900">Co-write, collaborate, grow</h3>
                        <p class="text-sm leading-relaxed text-zinc-500">Browse briefs for co-writes, toplines and sync placements, or post your own. Build your network at whatever pace suits you.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ── Features — Who it's for ───────────────────────────────────────────── --}}
        <section id="features" class="border-t border-zinc-100">
            <div class="mx-auto max-w-7xl">

                {{-- Section header --}}
                <div class="border-b border-zinc-100 px-6 py-10 md:px-10 md:py-12">
                    <p class="mb-3 flex items-center gap-2.5 text-xs font-semibold uppercase tracking-widest text-violet-600">
                        <span class="inline-block h-px w-6 bg-violet-400"></span>
                        Who's here
                    </p>
                    <h2 class="text-2xl font-bold text-zinc-900 md:text-3xl">For everyone who makes songs</h2>
                    <p class="mt-2 max-w-xl text-zinc-500">From bedroom hobbyists to platinum-credited writers — if songs are your thing, you belong here. SongwriterLink welcomes all levels, all genres, all backgrounds.</p>
                </div>

                {{-- 2×2 grid --}}
                <div class="grid md:grid-cols-2">
                    <div class="border-b p-8 md:border-r md:p-10 border-zinc-100">
                        <div class="mb-4 flex h-10 w-10 items-center justify-center rounded-lg bg-violet-50">
                            <svg class="h-5 w-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </div>
                        <h3 class="mb-2 font-semibold text-zinc-900">Songwriters &amp; Lyricists</h3>
                        <p class="text-sm leading-relaxed text-zinc-500">Whether you write in your bedroom or have major label cuts, share your work, find co-writers, and connect with people who speak your language.</p>
                    </div>
                    <div class="border-b p-8 md:p-10 border-zinc-100">
                        <div class="mb-4 flex h-10 w-10 items-center justify-center rounded-lg bg-violet-50">
                            <svg class="h-5 w-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                        </div>
                        <h3 class="mb-2 font-semibold text-zinc-900">Composers &amp; Producers</h3>
                        <p class="text-sm leading-relaxed text-zinc-500">Looking for a topline, a co-write, or someone to finish that bridge? Post a brief or browse profiles and find collaborators who fit your sound.</p>
                    </div>
                    <div class="border-b p-8 md:border-b-0 md:border-r md:p-10 border-zinc-100">
                        <div class="mb-4 flex h-10 w-10 items-center justify-center rounded-lg bg-violet-50">
                            <svg class="h-5 w-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <h3 class="mb-2 font-semibold text-zinc-900">Publishers &amp; A&amp;R</h3>
                        <p class="text-sm leading-relaxed text-zinc-500">Every profile is a real, verified person. Search by genre, role, and credits to find the writers you're actually looking for.</p>
                    </div>
                    <div class="p-8 md:p-10">
                        <div class="mb-4 flex h-10 w-10 items-center justify-center rounded-lg bg-violet-50">
                            <svg class="h-5 w-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/></svg>
                        </div>
                        <h3 class="mb-2 font-semibold text-zinc-900">Sync &amp; Film Composers</h3>
                        <p class="text-sm leading-relaxed text-zinc-500">Get discovered for sync briefs. Keep your portfolio, credits, and social links in one place — easy to share with supervisors and directors.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ── How it works ──────────────────────────────────────────────────────── --}}
        <section id="how" class="border-t border-zinc-100 bg-zinc-50">
            <div class="mx-auto max-w-7xl">

                {{-- Section header --}}
                <div class="border-b border-zinc-100 px-6 py-10 md:px-10 md:py-12">
                    <p class="mb-3 flex items-center gap-2.5 text-xs font-semibold uppercase tracking-widest text-violet-600">
                        <span class="inline-block h-px w-6 bg-violet-400"></span>
                        Getting started
                    </p>
                    <h2 class="text-2xl font-bold text-zinc-900 md:text-3xl">Up and running in minutes</h2>
                    <p class="mt-2 max-w-xl text-zinc-500">Join for free, verify who you are, then start browsing and connecting with songwriters across every genre and experience level.</p>
                </div>

                {{-- 4-col steps --}}
                <div class="grid md:grid-cols-4">
                    @php
                        $steps = [
                            ['num' => '01', 'title' => 'Join free',         'desc' => 'Create your account and pay a one-time £4 joining fee to keep the community spam-free.'],
                            ['num' => '02', 'title' => 'Quick ID check',    'desc' => 'A 2-minute government ID check via Stripe — keeps things genuine for everyone.'],
                            ['num' => '03', 'title' => 'Tell your story',   'desc' => 'Add your bio, genres, influences, social links, and upload tracks or lyrics to your portfolio.'],
                            ['num' => '04', 'title' => 'Start connecting',  'desc' => 'Message anyone, apply to co-write briefs, or post your own. Your next collaboration is already here.'],
                        ];
                    @endphp
                    @foreach($steps as $i => $step)
                        <div class="p-8 md:p-10{{ $i < 3 ? ' border-b md:border-b-0 md:border-r border-zinc-100' : '' }}">
                            <div class="mb-4 text-4xl font-bold text-zinc-200 md:text-5xl">{{ $step['num'] }}</div>
                            <h3 class="mb-2 font-semibold text-zinc-900">{{ $step['title'] }}</h3>
                            <p class="text-sm leading-relaxed text-zinc-500">{{ $step['desc'] }}</p>
                        </div>
                    @endforeach
                </div>

                {{-- CTA row --}}
                <div class="border-t border-zinc-100 px-6 py-8 md:px-10">
                    <a href="{{ route('onboarding.start') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand px-6 py-3 font-semibold text-white hover:bg-brand-dark transition">
                        Join the community
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
        </section>

        {{-- ── Pricing ───────────────────────────────────────────────────────────── --}}
        <section id="pricing" class="border-t border-zinc-100">
            <div class="mx-auto max-w-7xl">

                {{-- Section header --}}
                <div class="border-b border-zinc-100 px-6 py-10 md:px-10 md:py-12">
                    <p class="mb-3 flex items-center gap-2.5 text-xs font-semibold uppercase tracking-widest text-violet-600">
                        <span class="inline-block h-px w-6 bg-violet-400"></span>
                        Pricing
                    </p>
                    <h2 class="text-2xl font-bold text-zinc-900 md:text-3xl">Simple, transparent pricing</h2>
                    <p class="mt-2 max-w-xl text-zinc-500">Pay once for a fixed term, then choose to renew when it suits you. No recurring billing surprises.</p>
                </div>

                {{-- Pricing grid --}}
                <div class="grid md:grid-cols-3">

                    {{-- Free --}}
                    <div class="flex flex-col border-b p-8 md:border-b-0 md:border-r md:p-10 border-zinc-100">
                        <div class="mb-6">
                            <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400">Free</p>
                            <div class="mt-2 text-4xl font-bold text-zinc-900">£0</div>
                            <p class="mt-1 text-sm text-zinc-400">+ £4 joining fee</p>
                        </div>
                        <ul class="mb-8 flex-1 space-y-3 text-sm text-zinc-600">
                            <li class="flex items-center gap-2.5"><svg class="h-4 w-4 shrink-0 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Verified member profile</li>
                            <li class="flex items-center gap-2.5"><svg class="h-4 w-4 shrink-0 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Free direct messaging</li>
                            <li class="flex items-center gap-2.5"><svg class="h-4 w-4 shrink-0 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>3 portfolio uploads</li>
                            <li class="flex items-center gap-2.5"><svg class="h-4 w-4 shrink-0 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Browse &amp; apply to briefs</li>
                            <li class="flex items-center gap-2.5 text-zinc-400"><span class="inline-block h-4 w-4 shrink-0 text-center leading-4">—</span>Post briefs (£7 / post)</li>
                        </ul>
                        <a href="{{ route('onboarding.start') }}" class="block w-full rounded-lg border border-zinc-200 px-4 py-2.5 text-center text-sm font-semibold text-zinc-700 hover:border-zinc-300 hover:bg-zinc-50 transition">
                            Join free
                        </a>
                    </div>

                    {{-- Pro — highlighted --}}
                    <div class="relative flex flex-col border-b bg-violet-600 p-8 md:border-b-0 md:border-r md:p-10 border-zinc-100">
                        <div class="absolute right-4 top-4 rounded-full bg-white/20 px-2.5 py-0.5 text-xs font-semibold text-white">
                            Most popular
                        </div>
                        <div class="mb-6">
                            <p class="text-xs font-semibold uppercase tracking-widest text-violet-200">Pro</p>
                            <div class="mt-2 text-4xl font-bold text-white">£80<span class="text-lg font-normal text-violet-300"> / yr</span></div>
                            <p class="mt-1 text-sm text-violet-300">or £45 / 6 mo &middot; £25 / 3 mo</p>
                        </div>
                        <ul class="mb-8 flex-1 space-y-3 text-sm text-violet-100">
                            <li class="flex items-center gap-2.5"><svg class="h-4 w-4 shrink-0 text-violet-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Everything in Free</li>
                            <li class="flex items-center gap-2.5"><svg class="h-4 w-4 shrink-0 text-violet-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Unlimited portfolio uploads</li>
                            <li class="flex items-center gap-2.5"><svg class="h-4 w-4 shrink-0 text-violet-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Profile boost + search priority</li>
                            <li class="flex items-center gap-2.5"><svg class="h-4 w-4 shrink-0 text-violet-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Credits page &amp; PDF CV export</li>
                            <li class="flex items-center gap-2.5"><svg class="h-4 w-4 shrink-0 text-violet-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Split sheet generator</li>
                            <li class="flex items-center gap-2.5"><svg class="h-4 w-4 shrink-0 text-violet-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Profile analytics dashboard</li>
                        </ul>
                        <a href="{{ route('onboarding.start') }}" class="block w-full rounded-lg bg-white px-4 py-2.5 text-center text-sm font-semibold text-violet-700 hover:bg-violet-50 transition">
                            Get Pro
                        </a>
                    </div>

                    {{-- Pro+ --}}
                    <div class="flex flex-col p-8 md:p-10">
                        <div class="mb-6">
                            <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400">Pro+</p>
                            <div class="mt-2 text-4xl font-bold text-zinc-900">£180<span class="text-lg font-normal text-zinc-400"> / yr</span></div>
                            <p class="mt-1 text-sm text-zinc-400">or £100 / 6 mo &middot; £55 / 3 mo</p>
                        </div>
                        <ul class="mb-8 flex-1 space-y-3 text-sm text-zinc-600">
                            <li class="flex items-center gap-2.5"><svg class="h-4 w-4 shrink-0 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Everything in Pro</li>
                            <li class="flex items-center gap-2.5"><svg class="h-4 w-4 shrink-0 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Up to 5 open briefs at once</li>
                            <li class="flex items-center gap-2.5"><svg class="h-4 w-4 shrink-0 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Free brief posting (saves £7 / post)</li>
                            <li class="flex items-center gap-2.5"><svg class="h-4 w-4 shrink-0 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>View member social links</li>
                            <li class="flex items-center gap-2.5"><svg class="h-4 w-4 shrink-0 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Instant application alerts</li>
                            <li class="flex items-center gap-2.5"><svg class="h-4 w-4 shrink-0 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Promoted profile (1 per term)</li>
                        </ul>
                        <a href="{{ route('onboarding.start') }}" class="block w-full rounded-lg border border-zinc-200 px-4 py-2.5 text-center text-sm font-semibold text-zinc-700 hover:border-violet-300 hover:bg-violet-50 transition">
                            Get Pro+
                        </a>
                    </div>
                </div>

                <div class="border-t border-zinc-100 px-6 py-5 md:px-10">
                    <p class="text-xs text-zinc-400">
                        All payments handled securely by Stripe. No recurring billing — you choose when to renew.
                        All paid plans waive the £4 joining fee.
                    </p>
                </div>
            </div>
        </section>

        {{-- ── Dark CTA ──────────────────────────────────────────────────────────── --}}
        <section class="bg-zinc-950">
            <div class="mx-auto max-w-7xl">
                <div class="grid md:grid-cols-2">

                    {{-- Left: copy --}}
                    <div class="border-b p-8 md:border-b-0 md:border-r md:p-16 border-zinc-800">
                        <p class="mb-4 flex items-center gap-2.5 text-xs font-semibold uppercase tracking-widest text-violet-400">
                            <span class="inline-block h-px w-6 bg-violet-500"></span>
                            Your community
                        </p>
                        <h2 class="text-2xl font-bold text-white md:text-3xl">The place where<br/>songs get made</h2>
                        <p class="mt-4 leading-relaxed text-zinc-400">
                            We built SongwriterLink because finding genuine collaborators is hard. It's a community for songwriters at every level — hobbyists, up-and-comers, and career writers all in the same place, with the safety of knowing everyone is real.
                        </p>
                        <div class="mt-8 flex flex-wrap gap-3">
                            <a href="{{ route('onboarding.start') }}" class="inline-flex items-center gap-2 rounded-lg bg-violet-600 px-6 py-3 font-semibold text-white hover:bg-violet-500 transition">
                                Join the community
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                            <a href="{{ route('members.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-zinc-700 px-6 py-3 font-semibold text-zinc-300 hover:border-zinc-500 hover:text-white transition">
                                Browse members
                            </a>
                        </div>
                    </div>

                    {{-- Right: feature bullets --}}
                    <div class="p-8 md:p-16">
                        <p class="mb-6 text-xs font-semibold uppercase tracking-widest text-zinc-500">What you get</p>
                        <ul class="space-y-5">
                            @php
                                $bullets = [
                                    ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'text' => 'Songwriters, lyricists, producers, composers &amp; more'],
                                    ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'text' => 'Every member ID-verified — no fake accounts, ever'],
                                    ['icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z', 'text' => 'Free direct messaging — no credits or paywalls'],
                                    ['icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'text' => 'Browse and apply to real co-write &amp; sync briefs'],
                                    ['icon' => 'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3', 'text' => 'Portfolio, credits, split sheets &amp; CV export (Pro+)'],
                                ];
                            @endphp
                            @foreach($bullets as $bullet)
                                <li class="flex items-start gap-3">
                                    <div class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-md bg-violet-900/60">
                                        <svg class="h-3.5 w-3.5 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $bullet['icon'] }}"/></svg>
                                    </div>
                                    <span class="text-sm text-zinc-300">{!! $bullet['text'] !!}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        {{-- ── Footer ────────────────────────────────────────────────────────────── --}}
        <footer class="border-t border-zinc-100">
            <div class="mx-auto max-w-7xl">
                <div class="grid md:grid-cols-3">
                    <div class="border-b p-8 md:border-b-0 md:border-r md:p-10 border-zinc-100">
                        <a href="/" class="flex items-center gap-2">
                            <img src="/storage/songwriterlink_logo.png" alt="SongwriterLink" class="h-7 w-auto" />
                            <span class="font-semibold text-zinc-900">SongwriterLink</span>
                        </a>
                        <p class="mt-3 text-xs leading-relaxed text-zinc-400">Where songwriters, lyricists, composers &amp; producers find each other.</p>
                    </div>
                    <div class="border-b p-8 md:border-b-0 md:border-r md:p-10 border-zinc-100">
                        <p class="mb-3 text-xs font-semibold uppercase tracking-widest text-zinc-400">Product</p>
                        <ul class="space-y-2 text-sm text-zinc-500">
                            <li><a href="#trust"    class="hover:text-zinc-900 transition">Why it works</a></li>
                            <li><a href="#features" class="hover:text-zinc-900 transition">Features</a></li>
                            <li><a href="#how"      class="hover:text-zinc-900 transition">How it works</a></li>
                            <li><a href="#pricing"  class="hover:text-zinc-900 transition">Pricing</a></li>
                            <li><a href="{{ route('members.index') }}" class="hover:text-zinc-900 transition">Browse members</a></li>
                        </ul>
                    </div>
                    <div class="p-8 md:p-10">
                        <p class="mb-3 text-xs font-semibold uppercase tracking-widest text-zinc-400">Legal</p>
                        <ul class="space-y-2 text-sm text-zinc-500">
                            <li><a href="{{ route('privacy') }}" class="hover:text-zinc-900 transition">Privacy Policy</a></li>
                            <li><a href="{{ route('terms') }}"   class="hover:text-zinc-900 transition">Terms of Service</a></li>
                        </ul>
                        <p class="mt-8 text-xs text-zinc-400">&copy; {{ date('Y') }} SongwriterLink</p>
                    </div>
                </div>
            </div>
        </footer>

        @fluxScripts
    </body>
</html>
