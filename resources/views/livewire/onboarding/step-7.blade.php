<div>
    <flux:heading size="xl" class="text-center">Add a profile photo</flux:heading>
    <flux:subheading class="text-center">A clear, professional photo builds trust. Use a real photo of yourself — stock images are not permitted.</flux:subheading>

    <div class="flex justify-center">
        @if($photo)
            <img src="{{ $photo->temporaryUrl() }}" alt="Preview" class="h-32 w-32 rounded-full object-cover ring-2 ring-violet-400" />
        @elseif(auth()->user()->profile?->profile_photo_path)
            <img src="{{ Storage::url(auth()->user()->profile->profile_photo_path) }}" alt="Current photo" class="h-32 w-32 rounded-full object-cover ring-2 ring-zinc-200" />
        @else
            <div class="flex h-32 w-32 items-center justify-center rounded-full border-2 border-dashed border-zinc-200 bg-zinc-50 text-zinc-300">
                <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
        @endif
    </div>

    <label class="block w-full cursor-pointer rounded-lg border border-dashed border-zinc-300 bg-zinc-50 px-5 py-4 text-center text-sm text-zinc-500 hover:border-zinc-400 hover:bg-zinc-100 transition-colors">
        <input wire:model="photo" type="file" accept="image/*" class="sr-only" />
        {{ $photo ? 'Change photo' : 'Choose a photo' }}
        <span class="block mt-0.5 text-xs text-zinc-400">JPG, PNG or WebP — max 4 MB</span>
    </label>
    @error('photo') <p class="text-sm text-red-500">{{ $message }}</p> @enderror

    <flux:button wire:click="savePhoto" variant="primary" class="w-full">Save &amp; continue</flux:button>
    <button wire:click="skipPhoto" class="w-full text-sm text-zinc-400 hover:text-zinc-600">Skip for now</button>
</div>
