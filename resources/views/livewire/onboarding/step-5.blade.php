<div>
    <flux:heading size="xl" class="text-center">Set up your profile</flux:heading>
    <flux:subheading class="text-center">Your public profile — make it count. Be specific and genuine.</flux:subheading>

    <div class="space-y-4">
        <div>
            <flux:input wire:model="displayName" label="Display name" placeholder="The name you go by professionally" maxlength="100" />
            @error('displayName') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div x-data="{ bioLen: {{ strlen($bio) }} }">
            <flux:textarea wire:model="bio" x-on:input="bioLen = $event.target.value.length" label="Bio" placeholder="Your background, style, notable credits, what you're looking for. Minimum 50 characters." rows="4" maxlength="1000" />
            <div class="mt-1 flex justify-between text-xs text-zinc-400">
                <span x-bind:class="bioLen > 0 && bioLen < 50 ? 'text-red-400' : ''">Min 50 characters</span>
                <span x-text="bioLen + ' / 1000'" x-bind:class="bioLen >= 950 ? 'text-amber-500' : ''"></span>
            </div>
            @error('bio') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-3">
            <flux:input wire:model="location" label="City / Region" placeholder="e.g. Manchester" />
            <flux:input wire:model="country" label="Country" placeholder="e.g. United Kingdom" />
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-zinc-700">Genres <span class="text-zinc-400">(select all that apply)</span></label>
            @php $genreOptions = ['Pop','Rock','Hip-Hop / Rap','R&B / Soul','Country','Folk','Indie','Electronic','Jazz','Classical','Gospel / Christian','Reggae','Metal','Singer-Songwriter','World','Other']; @endphp
            <div class="flex flex-wrap gap-1.5">
                @foreach($genreOptions as $genre)
                    <button wire:click="toggleGenre('{{ $genre }}')" type="button"
                        class="rounded-full border px-3 py-1 text-xs font-medium transition-colors
                            {{ in_array($genre, $selectedGenres) ? 'border-violet-400 bg-violet-50 text-violet-700' : 'border-zinc-200 text-zinc-600 hover:border-zinc-300' }}">
                        {{ $genre }}
                    </button>
                @endforeach
            </div>
            @error('selectedGenres') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-zinc-700">Social &amp; professional links <span class="text-red-500">*</span></label>
            <p class="mb-3 text-xs text-zinc-400">At least one required.</p>
            <div class="space-y-2">
                <flux:input wire:model="socialLinks.spotify"    label="Spotify Artist URL"     placeholder="https://open.spotify.com/artist/..." />
                <flux:input wire:model="socialLinks.soundcloud" label="SoundCloud URL"          placeholder="https://soundcloud.com/..." />
                <flux:input wire:model="socialLinks.imdb"       label="IMDB URL"                placeholder="https://www.imdb.com/name/..." />
                <flux:input wire:model="socialLinks.linkedin"   label="LinkedIn URL"            placeholder="https://www.linkedin.com/in/..." />
                <flux:input wire:model="socialLinks.prs_ascap"  label="PRS / ASCAP Profile URL" placeholder="https://www.prsformusic.com/..." />
                <flux:input wire:model="socialLinks.discogs"    label="Discogs URL"             placeholder="https://www.discogs.com/artist/..." />
            </div>
            @error('socialLinks') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="pt-4 border-t border-zinc-100">
            <flux:button wire:click="saveProfile" variant="primary" class="w-full">
                Save &amp; continue
            </flux:button>
        </div>
    </div>
</div>
