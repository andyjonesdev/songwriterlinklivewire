
<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

    {{-- Header --}}
    <div class="h-32 w-full relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
        <h1 class="text-3xl mb-4">Upload a New Lyric</h1>
        <p>Use the form below to add a new lyric to your profile.</p>
    </div>

    {{-- Form --}}
    <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">

        <form wire:submit.prevent="submit">
            {{-- Title --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1">Title</label>
                <input wire:model.defer="title" type="text" class="w-full border px-3 py-2 rounded">
                @error('title') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            {{-- Meta --}}
            <div class="grid grid-cols-3 gap-4">
                <x-genre-select model="genre" />
                <x-mood-select model="mood" />
                <x-theme-select model="theme" />
                <x-pov-select model="pov" />
                <x-language-select model="language" />
                <x-price-select model="price" />
            </div>

            {{-- Lyrics --}}
            <div class="mb-4 mt-4">
                <label class="block font-semibold mb-1">Lyrics</label>
                <textarea wire:model.defer="content" rows="24" class="w-full border px-3 py-2 rounded"></textarea>
                @error('content') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            {{-- License --}}
            <h3 class="font-semibold mt-8 mb-4 text-xl">Standard License Terms:</h3>
            <ul class="list-disc ml-6">
                <li>Public performance rights</li>
                <li>Synchronization rights</li>
                <li>Internet broadcasting rights</li>
                <li>Reproduction rights</li>
                <li>Radio and television use</li>
                <li>Film, games, and theatre use</li>
            </ul>

            <p class="mt-4">
                If lyrics are used in a new song, the lyricist must be credited as a co-writer
                with a 25% writing share.
            </p>

            {{-- Submit --}}
            <button
                type="submit"
                class="my-4 rounded-sm bg-[#e8363c] px-5 py-2 text-lg text-white hover:bg-black"
                wire:loading.attr="disabled"
            >
                Upload Lyric
            </button>

            @if (session()->has('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session()->has('redirect_after'))
                <script>
                    setTimeout(() => {
                        window.location.href = '/lyrics';
                    }, 2000); // 2 seconds
                </script>
            @endif


        </form>
        
    </div>
</div>
