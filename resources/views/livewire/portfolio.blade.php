<x-layouts.app title="My Portfolio">
    <div class="mx-auto max-w-2xl space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900">My Portfolio</h1>
                <p class="mt-0.5 text-sm text-zinc-500">
                    {{ $count }} {{ Str::plural('item', $count) }}
                    @if($limit) &mdash; {{ max(0, $limit - $count) }} of {{ $limit }} remaining (free plan) @else &mdash; unlimited (Pro) @endif
                </p>
            </div>

            @if(! $atLimit || session('status'))
                <button wire:click="toggleForm"
                        class="flex items-center gap-1.5 rounded-lg bg-violet-600 px-4 py-2 text-sm font-semibold text-white hover:bg-violet-700 transition">
                    @if($showForm)
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Cancel
                    @else
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Upload item
                    @endif
                </button>
            @endif
        </div>

        {{-- Flash status --}}
        @if(session('status'))
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('status') }}</div>
        @endif

        {{-- Limit warning --}}
        @if($atLimit)
            <div class="rounded-xl border border-amber-200 bg-amber-50 p-4">
                <div class="flex items-start gap-3">
                    <svg class="h-5 w-5 mt-0.5 shrink-0 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <div>
                        <p class="text-sm font-semibold text-amber-800">Free plan limit reached</p>
                        <p class="mt-0.5 text-xs text-amber-700">You've used all {{ $limit }} free portfolio slots. Upgrade to Pro for unlimited uploads.</p>
                        <a href="{{ route('onboarding.step', 8) }}" wire:navigate
                           class="mt-2 inline-block text-xs font-semibold text-amber-700 underline hover:no-underline">
                            Upgrade to Pro →
                        </a>
                    </div>
                </div>
            </div>
        @endif

        {{-- Upload form --}}
        @if($showForm)
            <div class="rounded-xl border border-violet-200 bg-violet-50/40 p-5 space-y-4">
                <h2 class="text-sm font-semibold text-zinc-900">Upload a portfolio item</h2>

                {{-- Type toggle --}}
                <div class="flex gap-1 rounded-lg border border-zinc-200 bg-white p-1 w-fit">
                    <button wire:click="$set('type', 'audio')" type="button"
                            class="flex items-center gap-1.5 rounded-md px-4 py-1.5 text-xs font-medium transition-colors
                                   {{ $type === 'audio' ? 'bg-violet-600 text-white shadow-sm' : 'text-zinc-500 hover:text-zinc-700' }}">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                        Audio track
                    </button>
                    <button wire:click="$set('type', 'lyrics')" type="button"
                            class="flex items-center gap-1.5 rounded-md px-4 py-1.5 text-xs font-medium transition-colors
                                   {{ $type === 'lyrics' ? 'bg-violet-600 text-white shadow-sm' : 'text-zinc-500 hover:text-zinc-700' }}">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Lyrics / sheet
                    </button>
                </div>

                {{-- Title --}}
                <div>
                    <label class="mb-1 block text-xs font-medium text-zinc-700">Title <span class="text-red-500">*</span></label>
                    <input wire:model="title" type="text" maxlength="120" placeholder="Song or track title"
                           class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm focus:border-violet-400 focus:outline-none focus:ring-2 focus:ring-violet-100" />
                    @error('title') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="mb-1 block text-xs font-medium text-zinc-700">Description <span class="text-zinc-400">(optional)</span></label>
                    <input wire:model="description" type="text" maxlength="500"
                           placeholder="{{ $type === 'audio' ? 'e.g. Demo co-write, produced 2024' : 'e.g. Full lyrics with chord chart' }}"
                           class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm focus:border-violet-400 focus:outline-none focus:ring-2 focus:ring-violet-100" />
                    @error('description') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- File upload --}}
                <div>
                    <label class="mb-1 block text-xs font-medium text-zinc-700">File <span class="text-red-500">*</span></label>
                    <label class="flex cursor-pointer flex-col items-center gap-2 rounded-lg border-2 border-dashed border-zinc-300 bg-white px-5 py-6 text-center hover:border-violet-300 hover:bg-violet-50/40 transition-colors">
                        <input wire:model="file" type="file"
                               accept="{{ $type === 'audio' ? '.mp3,.wav,.aac,.m4a,.ogg' : '.pdf,.txt,.doc,.docx' }}"
                               class="sr-only" />
                        @if($file)
                            <svg class="h-6 w-6 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-sm font-medium text-violet-700">File selected</span>
                            <span class="text-xs text-zinc-400">Click to change</span>
                        @else
                            <svg class="h-6 w-6 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                            <span class="text-sm font-medium text-zinc-600">Click to upload</span>
                            <span class="text-xs text-zinc-400">
                                @if($type === 'audio') MP3, WAV, AAC, M4A — max 50 MB @else PDF, TXT, DOC — max 5 MB @endif
                            </span>
                        @endif
                    </label>
                    <div wire:loading wire:target="file" class="mt-2 flex items-center gap-1.5 text-xs text-zinc-400">
                        <svg class="h-3.5 w-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                        Uploading…
                    </div>
                    @error('file') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Visibility --}}
                <div class="flex items-center gap-3">
                    <label class="flex cursor-pointer items-center gap-2">
                        <input wire:model="isPublic" type="checkbox"
                               class="rounded border-zinc-300 text-violet-600 focus:ring-violet-500" />
                        <span class="text-sm text-zinc-700">Show on public profile</span>
                    </label>
                </div>

                {{-- Submit --}}
                <div class="pt-2 border-t border-zinc-200">
                    <button wire:click="save" wire:loading.attr="disabled"
                            class="w-full rounded-lg bg-violet-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-violet-700 disabled:opacity-60 transition">
                        <span wire:loading.remove wire:target="save">Save portfolio item</span>
                        <span wire:loading wire:target="save">Uploading…</span>
                    </button>
                </div>
            </div>
        @endif

        {{-- Existing items --}}
        @if($items->isNotEmpty())
            <div class="space-y-2">
                @foreach($items as $item)
                    <div class="flex items-center gap-3 rounded-xl border border-zinc-200 bg-white p-4">
                        {{-- Type icon --}}
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-violet-50 border border-violet-100">
                            @if($item->type === 'audio')
                                <svg class="h-4 w-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                            @else
                                <svg class="h-4 w-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <p class="truncate text-sm font-medium text-zinc-900">{{ $item->title }}</p>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="text-xs text-zinc-400 capitalize">{{ $item->type }}</span>
                                <span class="text-zinc-300">·</span>
                                <span class="text-xs text-zinc-400">{{ number_format($item->file_size / 1024, 0) }} KB</span>
                            </div>
                        </div>

                        {{-- Audio player --}}
                        @if($item->type === 'audio')
                            <audio controls class="h-8 max-w-40 shrink-0" preload="none">
                                <source src="{{ Storage::url($item->file_path) }}" />
                            </audio>
                        @endif

                        {{-- Visibility toggle --}}
                        <button wire:click="toggleVisibility({{ $item->id }})"
                                title="{{ $item->is_public ? 'Click to make private' : 'Click to make public' }}"
                                class="shrink-0 rounded-lg border px-2.5 py-1 text-xs font-medium transition-colors
                                       {{ $item->is_public
                                          ? 'border-green-200 bg-green-50 text-green-700 hover:bg-green-100'
                                          : 'border-zinc-200 bg-zinc-50 text-zinc-500 hover:bg-zinc-100' }}">
                            {{ $item->is_public ? 'Public' : 'Private' }}
                        </button>

                        {{-- Delete --}}
                        <button wire:click="delete({{ $item->id }})"
                                wire:confirm="Delete '{{ $item->title }}'? This cannot be undone."
                                class="shrink-0 rounded-lg border border-zinc-200 px-2.5 py-1 text-xs text-zinc-400 hover:border-red-200 hover:text-red-600 transition-colors">
                            Delete
                        </button>
                    </div>
                @endforeach
            </div>
        @elseif(! $showForm)
            <div class="flex flex-col items-center gap-3 rounded-xl border border-zinc-100 bg-zinc-50 py-12 text-center">
                <svg class="h-10 w-10 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                <p class="text-sm font-medium text-zinc-500">No portfolio items yet</p>
                <p class="text-xs text-zinc-400">Upload audio tracks or lyrics sheets to showcase your work.</p>
            </div>
        @endif
    </div>
</x-layouts.app>
