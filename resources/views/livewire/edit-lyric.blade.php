<div class="flex flex-col gap-4">

    <h1 class="text-2xl font-bold">Edit Lyric</h1>

    <form wire:submit.prevent="update">

        {{-- Title --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Title</label>
            <input wire:model.defer="title" class="w-full border px-3 py-2 rounded">
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
        <div class="mt-4">
            <label class="block font-semibold mb-1">Lyrics</label>
            <textarea wire:model.defer="content" rows="24" class="w-full border px-3 py-2 rounded"></textarea>
            @error('content') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Submit --}}
        <button
            type="submit"
            class="mt-4 rounded-sm bg-[#e8363c] px-5 py-2 text-lg text-white hover:bg-black"
            wire:loading.attr="disabled"
        >
            Save Changes
        </button>

        @if (session()->has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded my-4">
                {{ session('success') }}
            </div>
        @endif
    </form>

</div>
