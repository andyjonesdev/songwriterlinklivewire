<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <title>SongwriterLink — The Verified Songwriter Network</title>
    </head>
    <body class="min-h-screen bg-zinc-950 font-sans text-white">

        {{-- Nav --}}
        <nav class="mx-auto flex max-w-6xl items-center justify-between px-6 py-5">
            <a href="/" class="flex items-center gap-2">
                <x-app-logo />
            </a>
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm text-zinc-300 hover:text-white">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-zinc-300 hover:text-white">Sign in</a>
                    <a href="{{ route('onboarding.start') }}" class="rounded-lg bg-brand px-4 py-2 text-sm font-semibold text-white hover:bg-brand-dark">
                        Join free
                    </a>
                @endauth
            </div>
        </nav>

        {{-- Hero --}}
        <section class="mx-auto max-w-4xl px-6 py-24 text-center">
            <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-brand/30 bg-brand/10 px-4 py-1.5 text-sm text-brand-light">
                <span class="h-2 w-2 rounded-full bg-brand-light"></span>
                Every member is ID verified
            </div>
            <h1 class="mb-6 text-5xl font-bold leading-tight tracking-tight md:text-6xl">
                Connect with verified<br class="hidden md:block" /> songwriters &amp; producers
            </h1>
            <p class="mx-auto mb-10 max-w-2xl text-lg text-zinc-400">
                SongwriterLink is a professional networking platform for the music industry.
                Real people, real credits, free messaging — built on trust from day one.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('onboarding.start') }}" class="rounded-lg bg-brand px-8 py-3 font-semibold text-white hover:bg-brand-dark">
                    Apply for membership
                </a>
                <a href="{{ route('members.index') }}" class="rounded-lg border border-zinc-700 px-8 py-3 font-semibold text-zinc-300 hover:border-zinc-500 hover:text-white">
                    Browse members
                </a>
            </div>
        </section>

        {{-- Trust pillars --}}
        <section class="border-t border-zinc-800 py-20">
            <div class="mx-auto grid max-w-5xl grid-cols-1 gap-8 px-6 md:grid-cols-3">
                <div class="text-center">
                    <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-brand/10">
                        <svg class="h-6 w-6 text-brand-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="mb-2 font-semibold">ID Verified</h3>
                    <p class="text-sm text-zinc-400">Every member completes government ID verification via Stripe Identity. No fake profiles.</p>
                </div>
                <div class="text-center">
                    <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-brand/10">
                        <svg class="h-6 w-6 text-brand-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </div>
                    <h3 class="mb-2 font-semibold">Free Messaging</h3>
                    <p class="text-sm text-zinc-400">Message any verified member directly — no credits, no paywalls on communication.</p>
                </div>
                <div class="text-center">
                    <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-brand/10">
                        <svg class="h-6 w-6 text-brand-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="mb-2 font-semibold">Real Opportunities</h3>
                    <p class="text-sm text-zinc-400">Post and apply to briefs for co-writes, sync placements, toplines, and session work.</p>
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <footer class="border-t border-zinc-800 py-8 text-center text-sm text-zinc-500">
            <p>&copy; {{ date('Y') }} SongwriterLink. <a href="{{ route('privacy') }}" class="hover:text-zinc-300">Privacy</a> &middot; <a href="{{ route('terms') }}" class="hover:text-zinc-300">Terms</a></p>
        </footer>

        @fluxScripts
    </body>
</html>
