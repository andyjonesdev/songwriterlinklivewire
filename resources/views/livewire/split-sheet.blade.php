<div class="mx-auto max-w-3xl space-y-6">

    {{-- Page header --}}
    <div>
        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Split Sheet Generator</h1>
        <p class="mt-0.5 text-sm text-zinc-500">Create a professional split sheet PDF to document song ownership.</p>
    </div>

    @error('writers')
        <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">{{ $message }}</div>
    @enderror

    <form wire:submit="generatePdf" class="space-y-6">

        {{-- Song details card --}}
        <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
            <h2 class="mb-4 text-sm font-semibold text-zinc-700 dark:text-zinc-200">Song Details</h2>
            <div class="grid gap-4 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label class="mb-1 block text-xs font-medium text-zinc-700 dark:text-zinc-300">Song Title *</label>
                    <input wire:model="songTitle" type="text" placeholder="e.g. Better Days"
                           class="w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-violet-400 focus:outline-none dark:border-zinc-600 dark:bg-zinc-800 dark:text-white" />
                    @error('songTitle') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1 block text-xs font-medium text-zinc-700 dark:text-zinc-300">Recorded By / Artist</label>
                    <input wire:model="songArtist" type="text" placeholder="e.g. Various / TBC"
                           class="w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-violet-400 focus:outline-none dark:border-zinc-600 dark:bg-zinc-800 dark:text-white" />
                </div>

                <div>
                    <label class="mb-1 block text-xs font-medium text-zinc-700 dark:text-zinc-300">Date Written / Recorded</label>
                    <input wire:model="recordedDate" type="date"
                           class="w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-violet-400 focus:outline-none dark:border-zinc-600 dark:bg-zinc-800 dark:text-white" />
                    @error('recordedDate') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1 block text-xs font-medium text-zinc-700 dark:text-zinc-300">ISRC</label>
                    <input wire:model="isrc" type="text" placeholder="e.g. GBUM71234567"
                           class="w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-violet-400 focus:outline-none dark:border-zinc-600 dark:bg-zinc-800 dark:text-white" />
                </div>

                <div>
                    <label class="mb-1 block text-xs font-medium text-zinc-700 dark:text-zinc-300">ISWC</label>
                    <input wire:model="iswc" type="text" placeholder="e.g. T-345246800-1"
                           class="w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-violet-400 focus:outline-none dark:border-zinc-600 dark:bg-zinc-800 dark:text-white" />
                </div>

                <div>
                    <label class="mb-1 block text-xs font-medium text-zinc-700 dark:text-zinc-300">Publisher</label>
                    <input wire:model="publisher" type="text" placeholder="e.g. Warner Chappell"
                           class="w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-violet-400 focus:outline-none dark:border-zinc-600 dark:bg-zinc-800 dark:text-white" />
                </div>

                <div class="sm:col-span-2">
                    <label class="mb-1 block text-xs font-medium text-zinc-700 dark:text-zinc-300">Notes</label>
                    <textarea wire:model="notes" rows="2" placeholder="Any additional notes…"
                              class="w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-violet-400 focus:outline-none dark:border-zinc-600 dark:bg-zinc-800 dark:text-white"></textarea>
                </div>
            </div>
        </div>

        {{-- Writers card --}}
        <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-sm font-semibold text-zinc-700 dark:text-zinc-200">Writers &amp; Splits</h2>

                {{-- Share total indicator --}}
                <div class="flex items-center gap-2">
                    <span class="text-xs text-zinc-500">Total:</span>
                    <span class="rounded-full px-2 py-0.5 text-xs font-bold
                        {{ abs($totalShare - 100) < 0.01 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                        {{ number_format($totalShare, 2) }}%
                    </span>
                    @if(abs($totalShare - 100) < 0.01)
                        <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    @endif
                </div>
            </div>

            <div class="space-y-3">
                @foreach($writers as $i => $writer)
                    <div class="grid items-start gap-3 rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800/50
                                grid-cols-[1fr_auto] sm:grid-cols-[2fr_1.5fr_1fr_auto]">

                        <div>
                            <label class="mb-1 block text-xs text-zinc-500">Full Name *</label>
                            <input wire:model="writers.{{ $i }}.name" type="text" placeholder="Writer name"
                                   class="w-full rounded border border-zinc-200 px-2 py-1.5 text-sm focus:border-violet-400 focus:outline-none dark:border-zinc-600 dark:bg-zinc-700 dark:text-white" />
                            @error("writers.{$i}.name") <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="hidden sm:block">
                            <label class="mb-1 block text-xs text-zinc-500">Role *</label>
                            <select wire:model="writers.{{ $i }}.role"
                                    class="w-full rounded border border-zinc-200 px-2 py-1.5 text-sm focus:border-violet-400 focus:outline-none dark:border-zinc-600 dark:bg-zinc-700 dark:text-white">
                                <option>Songwriter</option>
                                <option>Composer</option>
                                <option>Lyricist</option>
                                <option>Producer</option>
                                <option>Topliner</option>
                                <option>Co-writer</option>
                            </select>
                        </div>

                        <div>
                            <label class="mb-1 block text-xs text-zinc-500">Share % *</label>
                            <input wire:model="writers.{{ $i }}.share" type="number" step="0.01" min="0" max="100" placeholder="e.g. 50"
                                   class="w-full rounded border border-zinc-200 px-2 py-1.5 text-sm focus:border-violet-400 focus:outline-none dark:border-zinc-600 dark:bg-zinc-700 dark:text-white" />
                            @error("writers.{$i}.share") <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-end justify-end pb-0.5">
                            @if(count($writers) > 1)
                                <button type="button" wire:click="removeWriter({{ $i }})"
                                        class="rounded p-1.5 text-zinc-300 hover:text-red-400 transition">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            @else
                                <div class="h-7 w-7"></div>
                            @endif
                        </div>

                        {{-- PRO / IPI on second row --}}
                        <div class="col-span-2 sm:col-span-4">
                            <div class="grid gap-3 sm:grid-cols-2">
                                <div>
                                    <label class="mb-1 block text-xs text-zinc-500">PRO / Collection Society</label>
                                    <input wire:model="writers.{{ $i }}.pro" type="text" placeholder="e.g. PRS, ASCAP, BMI"
                                           class="w-full rounded border border-zinc-200 px-2 py-1.5 text-sm focus:border-violet-400 focus:outline-none dark:border-zinc-600 dark:bg-zinc-700 dark:text-white" />
                                </div>
                                <div>
                                    <label class="mb-1 block text-xs text-zinc-500">IPI / CAE Number</label>
                                    <input wire:model="writers.{{ $i }}.ipi" type="text" placeholder="e.g. 00123456789"
                                           class="w-full rounded border border-zinc-200 px-2 py-1.5 text-sm focus:border-violet-400 focus:outline-none dark:border-zinc-600 dark:bg-zinc-700 dark:text-white" />
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="button" wire:click="addWriter"
                    class="mt-3 inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-sm font-medium text-violet-600 hover:bg-violet-50 transition dark:hover:bg-violet-900/20">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Writer
            </button>
        </div>

        {{-- Generate button --}}
        <div class="flex items-center justify-between">
            <p class="text-xs text-zinc-400">Shares must total exactly 100% before you can generate.</p>
            <button type="submit"
                    wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 rounded-lg bg-violet-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-violet-700 disabled:opacity-50 transition">
                <span wire:loading.remove wire:target="generatePdf">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Generate PDF
                </span>
                <span wire:loading wire:target="generatePdf">Generating…</span>
            </button>
        </div>
    </form>

</div>
