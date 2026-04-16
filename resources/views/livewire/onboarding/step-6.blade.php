<div>
    <flux:heading size="xl" class="text-center">Add a profile photo</flux:heading>
    <flux:subheading class="text-center">A clear, professional photo builds trust. Use a real photo of yourself — stock images are not permitted.</flux:subheading>

    {{-- Photo preview + upload zone --}}
    <div x-data="{ dragging: false }"
         x-on:dragover.prevent="dragging = true"
         x-on:dragleave.prevent="dragging = false"
         x-on:drop.prevent="dragging = false">

        @if($photo)
            {{-- Preview after selection --}}
            <div class="flex flex-col items-center gap-3">
                <img src="{{ $photo->temporaryUrl() }}" alt="Preview" class="h-32 w-32 rounded-full object-cover ring-4 ring-violet-400 shadow-md" />
                <p class="text-xs text-zinc-400">Looking good! Save &amp; continue, or choose a different photo below.</p>
            </div>
        @elseif(auth()->user()->profile?->profile_photo_path)
            {{-- Existing photo --}}
            <div class="flex flex-col items-center gap-3">
                <img src="{{ Storage::url(auth()->user()->profile->profile_photo_path) }}" alt="Current photo" class="h-32 w-32 rounded-full object-cover ring-4 ring-zinc-200 shadow-md" />
                <p class="text-xs text-zinc-400">Your current photo. Choose a new one below to replace it.</p>
            </div>
        @endif

        {{-- Upload zone --}}
        <label class="mt-4 flex flex-col items-center gap-3 w-full cursor-pointer rounded-xl border-2 border-dashed px-6 py-8 text-center transition-colors"
               :class="dragging ? 'border-violet-400 bg-violet-50' : 'border-zinc-300 bg-zinc-50 hover:border-violet-300 hover:bg-violet-50/50'">
            <input wire:model="photo" type="file" accept="image/*" class="sr-only" />

            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-white border border-zinc-200 shadow-sm">
                <svg class="h-6 w-6 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>

            <div>
                <p class="text-sm font-medium text-zinc-700">
                    {{ $photo ? 'Change photo' : 'Click to upload a photo' }}
                </p>
                <p class="mt-0.5 text-xs text-zinc-400">or drag and drop here</p>
                <p class="mt-1 text-xs text-zinc-400">JPG, PNG or WebP — max 4 MB</p>
            </div>
        </label>
    </div>

    @error('photo') <p class="text-sm text-red-500">{{ $message }}</p> @enderror

    <div wire:loading wire:target="photo" class="flex items-center gap-2 text-sm text-zinc-400">
        <svg class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
        </svg>
        Uploading…
    </div>

    <div class="pt-4 border-t border-zinc-100 space-y-2">
        <flux:button wire:click="savePhoto" variant="primary" class="w-full">Save &amp; continue</flux:button>
        <button wire:click="skipPhoto" class="w-full text-sm text-zinc-400 hover:text-zinc-600">Skip for now</button>
    </div>
</div>
