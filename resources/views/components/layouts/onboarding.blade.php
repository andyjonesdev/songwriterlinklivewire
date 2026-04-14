<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <title>Join SongwriterLink</title>
    </head>
    <body class="min-h-screen bg-zinc-950 font-sans text-white">

        <div class="mx-auto flex min-h-screen max-w-2xl flex-col px-6 py-10">

            {{-- Logo --}}
            <div class="mb-8 flex items-center gap-2">
                <a href="/" wire:navigate>
                    <img src="/storage/songwriterlink_logo.png" alt="SongwriterLink" class="h-8 w-auto" />
                </a>
            </div>

            {{-- Step content --}}
            <div class="flex-1">
                {{ $slot }}
            </div>

            {{-- Footer --}}
            <div class="mt-10 text-center text-xs text-zinc-600">
                &copy; {{ date('Y') }} SongwriterLink &middot;
                <a href="{{ route('privacy') }}" class="hover:text-zinc-400">Privacy</a> &middot;
                <a href="{{ route('terms') }}" class="hover:text-zinc-400">Terms</a>
            </div>
        </div>

        @fluxScripts
    </body>
</html>
