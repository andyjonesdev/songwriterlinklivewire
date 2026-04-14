
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
            <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
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

            {{-- Originality Disclaimer & Confirmation --}}
            <div class="mt-6 mb-4 p-4 bg-amber-50 border border-amber-300 rounded-lg dark:bg-amber-950 dark:border-amber-700">
                <p class="text-sm text-amber-800 dark:text-amber-200 font-semibold mb-1">Important Notice</p>
                <p class="text-sm text-amber-700 dark:text-amber-300">We do not accept AI-generated lyrics or lyrics not written by yourself. Uploading lyrics that are not your own original work may result in your account being suspended.</p>

<p class="text-sm text-amber-700 dark:text-amber-300 my-2">To use our service, you must either fully own the rights to any material you upload, license, or sell through SongwriterLink — or own a share of the rights and have obtained explicit permission from all co-writers or rights holders.</p>

<p class="text-sm text-amber-700 dark:text-amber-300 my-2">If you do not hold these rights, or do not have permission from all relevant parties, you are not permitted to use our service. If you’re unsure about any of these terms, please seek clarification before uploading your work.</p>

<p class="text-sm text-amber-700 dark:text-amber-300">Do not upload material that you do not own or works by other artists. Unauthorized use of copyrighted material is a serious offense and may result in legal action.</p>

            </div>


           

            <div class="mb-4 flex items-start gap-3">
                <input
                    wire:model.defer="originalConfirmed"
                    type="checkbox"
                    id="originalConfirmed"
                    class="mt-1 h-4 w-4 rounded border-gray-300 text-[#e8363c] focus:ring-[#e8363c] cursor-pointer"
                >
                <label for="originalConfirmed" class="text-sm cursor-pointer">
                    I confirm that I own the rights or have permission to use these lyrics, and they are not AI-generated.
                </label>
            </div>
            @error('originalConfirmed') <p class="text-red-500 text-sm mb-4">{{ $message }}</p> @enderror

            {{-- Submit --}}
            <button
                type="submit"
                class="my-4 rounded-sm bg-[#e8363c] px-5 py-2 text-lg text-white hover:bg-black disabled:opacity-50 disabled:cursor-not-allowed"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove wire:target="submit">Upload Lyric</span>
                <span wire:loading wire:target="submit" class="inline-flex items-center gap-2">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    Checking lyrics with AI...
                </span>
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
