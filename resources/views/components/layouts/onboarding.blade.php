<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
        <title>Join SongwriterLink</title>
    </head>
    <body class="min-h-screen bg-white font-sans text-zinc-900 antialiased">
        <div class="flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div class="flex w-full max-w-lg flex-col gap-6">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2" wire:navigate>
                    <img src="/storage/songwriterlink_logo.png" alt="SongwriterLink" class="h-10 w-auto" />
                </a>

                {{-- Step content --}}
                <div class="flex flex-col gap-6 rounded-xl border border-zinc-200 bg-white px-8 py-8 shadow-xs">
                    {{ $slot }}
                </div>

                {{-- Footer --}}
                <p class="text-center text-xs text-zinc-400">
                    &copy; {{ date('Y') }} SongwriterLink &middot;
                    <a href="{{ route('privacy') }}" class="hover:text-zinc-600">Privacy</a> &middot;
                    <a href="{{ route('terms') }}" class="hover:text-zinc-600">Terms</a>
                </p>
            </div>
        </div>

        @fluxScripts
    </body>
</html>
