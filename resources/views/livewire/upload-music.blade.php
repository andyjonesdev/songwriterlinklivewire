<div class="mx-auto">
    <h1 class="text-2xl font-bold mb-4">Upload Music</h1>

    @if ($success)
        <div class="mb-4 text-green-600">
            Music uploaded successfully!
        </div>
    @endif

    <form wire:submit.prevent="save" enctype="multipart/form-data" class="space-y-4">
        <div>
            <label class="block font-semibold">Title</label>
            <input wire:model.defer="title" type="text" class="lg:w-1/2 border p-2 rounded">
            @error('title') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block font-semibold">Audio File</label>
            <input wire:model="audio" type="file" accept=".mp3,.wav" 
            class="py-2 w-fit text-lg underline">
            @error('audio') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

            <div wire:loading wire:target="audio" class="text-sm text-gray-500">
                Uploading…
            </div>
        </div>

        <button
            type="submit"
            class="rounded-sm border bg-[#e8363c] px-5 py-2 text-lg text-white hover:bg-black"
        >
            Upload Music
        </button>
    </form>
</div>
