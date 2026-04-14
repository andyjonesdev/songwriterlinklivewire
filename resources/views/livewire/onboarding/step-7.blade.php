<div>
    <h1 class="mb-2 text-2xl font-bold">Add a profile photo</h1>
    <p class="mb-8 text-sm text-zinc-400">A clear, professional photo builds trust. Use a real photo of yourself — stock images are not permitted.</p>

    <div class="space-y-6">
        @if($photo)
            <div class="flex justify-center">
                <img src="{{ $photo->temporaryUrl() }}" alt="Preview" class="h-40 w-40 rounded-full object-cover ring-2 ring-brand" />
            </div>
        @elseif(auth()->user()->profile?->profile_photo_path)
            <div class="flex justify-center">
                <img src="{{ Storage::url(auth()->user()->profile->profile_photo_path) }}" alt="Current photo" class="h-40 w-40 rounded-full object-cover ring-2 ring-zinc-600" />
            </div>
        @else
            <div class="flex h-40 w-40 mx-auto items-center justify-center rounded-full border-2 border-dashed border-zinc-700 bg-zinc-900 text-zinc-600">
                <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
        @endif

        <div>
            <label class="block w-full cursor-pointer rounded-xl border border-dashed border-zinc-700 bg-zinc-900 px-5 py-4 text-center text-sm text-zinc-400 hover:border-zinc-500 hover:text-zinc-300 transition-colors">
                <input wire:model="photo" type="file" accept="image/*" class="sr-only" />
                {{ $photo ? 'Change photo' : 'Choose a photo' }}
                <span class="block mt-0.5 text-xs text-zinc-600">JPG, PNG or WebP — max 4MB</span>
            </label>
            @error('photo') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
        </div>

        <div class="space-y-3">
            <flux:button wire:click="savePhoto" variant="primary" class="w-full">
                Save &amp; continue
            </flux:button>
            <button wire:click="skipPhoto" class="w-full text-sm text-zinc-500 hover:text-zinc-300">
                Skip for now
            </button>
        </div>
    </div>
</div>
