<div class="mx-auto max-w-2xl space-y-6">

    {{-- Back --}}
    <a href="{{ route('briefs.index') }}" wire:navigate
       class="flex items-center gap-1 text-sm text-zinc-400 hover:text-zinc-600 transition-colors">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Brief Board
    </a>

    <div>
        <h1 class="text-2xl font-bold text-zinc-900">Post a Brief</h1>
        <p class="mt-1 text-sm text-zinc-500">Describe what you're looking for — verified members will apply with a pitch.</p>
    </div>

    @if(session('status'))
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('status') }}</div>
    @endif

    @if($errors->has('title') && str_contains($errors->first('title'), 'Pro'))
        <div class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">{{ $errors->first('title') }}</div>
    @endif

    <div class="rounded-xl border border-zinc-200 bg-white p-6 space-y-5">

        {{-- Title --}}
        <div>
            <label class="mb-1.5 block text-sm font-medium text-zinc-700">Brief title <span class="text-red-500">*</span></label>
            <input wire:model="title" type="text" maxlength="120" placeholder="e.g. Looking for a topline vocalist for dark pop track"
                   class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2.5 text-sm text-zinc-900 placeholder-zinc-400 focus:border-violet-400 focus:outline-none focus:ring-2 focus:ring-violet-100" />
            @error('title') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        {{-- Category --}}
        <div>
            <label class="mb-1.5 block text-sm font-medium text-zinc-700">Category <span class="text-red-500">*</span></label>
            <select wire:model="category"
                    class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2.5 text-sm text-zinc-700 focus:border-violet-400 focus:outline-none focus:ring-2 focus:ring-violet-100">
                <option value="">Select a category…</option>
                @foreach($categories as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
            @error('category') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        {{-- Description --}}
        <div>
            <label class="mb-1.5 block text-sm font-medium text-zinc-700">Description <span class="text-red-500">*</span></label>
            <textarea wire:model="description" rows="5" maxlength="3000"
                      placeholder="Describe the project: genre, mood, reference tracks, what you're looking for in a collaborator, rights split expectations…"
                      class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2.5 text-sm text-zinc-900 placeholder-zinc-400 focus:border-violet-400 focus:outline-none focus:ring-2 focus:ring-violet-100 resize-none"></textarea>
            @error('description') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        {{-- Genres --}}
        <div>
            <label class="mb-1.5 block text-sm font-medium text-zinc-700">Genres <span class="text-zinc-400 font-normal">(up to 5)</span></label>
            <div class="flex flex-wrap gap-2">
                @foreach($genres as $genre)
                    <label class="flex cursor-pointer items-center gap-1.5 rounded-full border px-3 py-1 text-xs font-medium transition-colors
                                  {{ in_array($genre, $genres) && in_array($genre, (array) $this->genres)
                                     ? 'border-violet-300 bg-violet-50 text-violet-700'
                                     : 'border-zinc-200 bg-white text-zinc-600 hover:border-zinc-300' }}">
                        <input type="checkbox" wire:model="genres" value="{{ $genre }}" class="sr-only" />
                        {{ $genre }}
                    </label>
                @endforeach
            </div>
            @error('genres') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        {{-- Compensation --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">Compensation type <span class="text-red-500">*</span></label>
                <select wire:model="compensationType"
                        class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2.5 text-sm text-zinc-700 focus:border-violet-400 focus:outline-none focus:ring-2 focus:ring-violet-100">
                    <option value="">Select…</option>
                    @foreach($compensationTypes as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
                @error('compensationType') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">Compensation detail <span class="text-zinc-400 font-normal">(optional)</span></label>
                <input wire:model="compensationDetail" type="text" maxlength="255"
                       placeholder="e.g. 50/50 split, £500 flat fee…"
                       class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2.5 text-sm text-zinc-900 placeholder-zinc-400 focus:border-violet-400 focus:outline-none focus:ring-2 focus:ring-violet-100" />
                @error('compensationDetail') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Deadline --}}
        <div>
            <label class="mb-1.5 block text-sm font-medium text-zinc-700">Submission deadline <span class="text-zinc-400 font-normal">(optional)</span></label>
            <input wire:model="deadline" type="date" min="{{ now()->addDay()->toDateString() }}"
                   class="rounded-lg border border-zinc-200 bg-white px-3 py-2.5 text-sm text-zinc-700 focus:border-violet-400 focus:outline-none focus:ring-2 focus:ring-violet-100" />
            @error('deadline') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            <p class="mt-1 text-xs text-zinc-400">Briefs expire automatically after 60 days.</p>
        </div>

        {{-- Submit --}}
        <div class="pt-2 border-t border-zinc-100">
            <button wire:click="save" wire:loading.attr="disabled"
                    class="w-full rounded-lg bg-violet-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-violet-700 disabled:opacity-60 transition">
                <span wire:loading.remove wire:target="save">Post brief</span>
                <span wire:loading wire:target="save">Posting…</span>
            </button>
        </div>
    </div>
</div>
