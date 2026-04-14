<div>
    <h1 class="mb-2 text-2xl font-bold">Set up your profile</h1>
    <p class="mb-8 text-sm text-zinc-400">This is your public profile — make it count. Be specific and genuine.</p>

    <div class="space-y-5">
        <flux:input
            wire:model="displayName"
            label="Display name"
            placeholder="The name you go by professionally"
            maxlength="100"
        />
        @error('displayName') <p class="-mt-3 text-sm text-red-400">{{ $message }}</p> @enderror

        <div>
            <flux:textarea
                wire:model="bio"
                label="Bio"
                placeholder="Tell the industry who you are — your background, style, notable credits, what you're looking for. Be specific. Minimum 50 characters."
                rows="5"
                maxlength="1000"
            />
            <div class="mt-1 flex justify-between text-xs text-zinc-500">
                <span>Min 50 characters</span>
                <span>{{ strlen($bio) }} / 1000</span>
            </div>
        </div>
        @error('bio') <p class="-mt-3 text-sm text-red-400">{{ $message }}</p> @enderror

        <div class="grid grid-cols-2 gap-4">
            <flux:input wire:model="location" label="City / Region" placeholder="e.g. Manchester" />
            <flux:input wire:model="country" label="Country" placeholder="e.g. United Kingdom" />
        </div>

        {{-- Genres --}}
        <div>
            <label class="mb-2 block text-sm font-medium text-zinc-300">Genres <span class="text-zinc-500">(select all that apply)</span></label>
            @php
                $genreOptions = ['Pop','Rock','Hip-Hop / Rap','R&B / Soul','Country','Folk','Indie','Electronic','Jazz','Classical','Gospel / Christian','Reggae','Metal','Singer-Songwriter','World','Other'];
            @endphp
            <div class="flex flex-wrap gap-2">
                @foreach($genreOptions as $genre)
                    <button
                        wire:click="$toggle('selectedGenres', '{{ $genre }}')"
                        type="button"
                        class="rounded-full border px-3 py-1 text-sm transition-colors
                            {{ in_array($genre, $selectedGenres)
                                ? 'border-brand bg-brand/20 text-brand-light'
                                : 'border-zinc-700 text-zinc-400 hover:border-zinc-500' }}"
                    >
                        {{ $genre }}
                    </button>
                @endforeach
            </div>
            @error('selectedGenres') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
        </div>

        {{-- Social links --}}
        <div>
            <label class="mb-1 block text-sm font-medium text-zinc-300">Social &amp; professional links <span class="text-red-400">*</span></label>
            <p class="mb-3 text-xs text-zinc-500">At least one required. These help verify your professional presence.</p>
            <div class="space-y-3">
                <flux:input wire:model="socialLinks.spotify" label="Spotify Artist URL" placeholder="https://open.spotify.com/artist/..." />
                <flux:input wire:model="socialLinks.soundcloud" label="SoundCloud URL" placeholder="https://soundcloud.com/..." />
                <flux:input wire:model="socialLinks.imdb" label="IMDB URL" placeholder="https://www.imdb.com/name/..." />
                <flux:input wire:model="socialLinks.linkedin" label="LinkedIn URL" placeholder="https://www.linkedin.com/in/..." />
                <flux:input wire:model="socialLinks.prs_ascap" label="PRS / ASCAP Profile URL" placeholder="https://www.prsformusic.com/..." />
                <flux:input wire:model="socialLinks.discogs" label="Discogs URL" placeholder="https://www.discogs.com/artist/..." />
            </div>
            @error('socialLinks') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
        </div>

        <flux:button wire:click="saveProfile" variant="primary" class="w-full">
            Save profile &amp; continue
        </flux:button>
    </div>
</div>
