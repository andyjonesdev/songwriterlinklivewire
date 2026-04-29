<div class="mx-auto max-w-3xl space-y-6">

    {{-- Page header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Credits &amp; CV</h1>
            <p class="mt-0.5 text-sm text-zinc-500">Your writing credits — exported as a professional PDF CV.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('credits.export') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-violet-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-violet-700 transition">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Export PDF CV
            </a>
            <button wire:click="openForm()"
                    class="inline-flex items-center gap-2 rounded-lg border border-zinc-200 px-4 py-2 text-sm font-semibold text-zinc-700 hover:border-zinc-300 hover:bg-zinc-50 transition dark:border-zinc-600 dark:text-zinc-200 dark:hover:bg-zinc-800">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Credit
            </button>
        </div>
    </div>

    {{-- Add / Edit form --}}
    @if($showForm)
        <div class="rounded-xl border border-violet-200 bg-violet-50 p-5 dark:border-violet-800 dark:bg-violet-950/30">
            <h2 class="mb-4 text-sm font-semibold text-violet-700 dark:text-violet-300">
                {{ $editingId ? 'Edit Credit' : 'Add Credit' }}
            </h2>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="mb-1 block text-xs font-medium text-zinc-700 dark:text-zinc-300">Song / Work Title *</label>
                    <input wire:model="newTitle" type="text" placeholder="e.g. Better Days"
                           class="w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-violet-400 focus:outline-none dark:border-zinc-600 dark:bg-zinc-800 dark:text-white" />
                    @error('newTitle') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1 block text-xs font-medium text-zinc-700 dark:text-zinc-300">Your Role *</label>
                    <input wire:model="newRole" type="text" placeholder="e.g. Songwriter, Composer, Producer"
                           class="w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-violet-400 focus:outline-none dark:border-zinc-600 dark:bg-zinc-800 dark:text-white" />
                    @error('newRole') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1 block text-xs font-medium text-zinc-700 dark:text-zinc-300">Artist / Project</label>
                    <input wire:model="newArtist" type="text" placeholder="e.g. Various / Self"
                           class="w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-violet-400 focus:outline-none dark:border-zinc-600 dark:bg-zinc-800 dark:text-white" />
                </div>

                <div>
                    <label class="mb-1 block text-xs font-medium text-zinc-700 dark:text-zinc-300">Year</label>
                    <input wire:model="newYear" type="number" placeholder="{{ date('Y') }}" min="1900" max="{{ date('Y') + 1 }}"
                           class="w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-violet-400 focus:outline-none dark:border-zinc-600 dark:bg-zinc-800 dark:text-white" />
                    @error('newYear') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1 block text-xs font-medium text-zinc-700 dark:text-zinc-300">Label / Publisher</label>
                    <input wire:model="newLabel" type="text" placeholder="e.g. Warner Chappell"
                           class="w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-violet-400 focus:outline-none dark:border-zinc-600 dark:bg-zinc-800 dark:text-white" />
                </div>

                <div>
                    <label class="mb-1 block text-xs font-medium text-zinc-700 dark:text-zinc-300">ISRC</label>
                    <input wire:model="newIsrc" type="text" placeholder="e.g. GBUM71234567"
                           class="w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-violet-400 focus:outline-none dark:border-zinc-600 dark:bg-zinc-800 dark:text-white" />
                </div>

                <div class="sm:col-span-2">
                    <label class="mb-1 block text-xs font-medium text-zinc-700 dark:text-zinc-300">Notes</label>
                    <textarea wire:model="newDescription" rows="2" placeholder="Additional context…"
                              class="w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-violet-400 focus:outline-none dark:border-zinc-600 dark:bg-zinc-800 dark:text-white"></textarea>
                </div>
            </div>

            <div class="mt-4 flex items-center gap-3">
                <button wire:click="saveCredit" wire:loading.attr="disabled"
                        class="rounded-lg bg-violet-600 px-4 py-2 text-sm font-semibold text-white hover:bg-violet-700 disabled:opacity-50 transition">
                    <span wire:loading.remove wire:target="saveCredit">{{ $editingId ? 'Update' : 'Save' }}</span>
                    <span wire:loading wire:target="saveCredit">Saving…</span>
                </button>
                <button wire:click="$set('showForm', false)"
                        class="rounded-lg px-4 py-2 text-sm font-medium text-zinc-500 hover:text-zinc-700 transition">
                    Cancel
                </button>
            </div>
        </div>
    @endif

    {{-- Credits list --}}
    @if($credits->isEmpty())
        <div class="flex flex-col items-center gap-3 rounded-xl border border-zinc-100 bg-zinc-50 py-16 text-center dark:border-zinc-700 dark:bg-zinc-800/50">
            <svg class="h-10 w-10 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
            </svg>
            <div>
                <p class="text-sm font-medium text-zinc-500">No credits yet</p>
                <p class="mt-0.5 text-xs text-zinc-400">Add your writing credits to generate a professional CV.</p>
            </div>
        </div>
    @else
        <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
            <table class="min-w-full divide-y divide-zinc-100 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-zinc-500">Title</th>
                        <th class="hidden px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-zinc-500 sm:table-cell">Role</th>
                        <th class="hidden px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-zinc-500 md:table-cell">Artist</th>
                        <th class="hidden px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-zinc-500 lg:table-cell">Label</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-zinc-500">Year</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @foreach($credits as $credit)
                        <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/50 transition">
                            <td class="px-4 py-3">
                                <p class="font-semibold text-zinc-900 dark:text-white">{{ $credit->title }}</p>
                                @if($credit->description)
                                    <p class="mt-0.5 text-xs text-zinc-400">{{ $credit->description }}</p>
                                @endif
                                <p class="mt-0.5 hidden text-xs text-violet-600 sm:hidden">{{ $credit->role }}</p>
                            </td>
                            <td class="hidden px-4 py-3 sm:table-cell">
                                <span class="inline-flex items-center rounded-full bg-violet-100 px-2 py-0.5 text-xs font-semibold text-violet-700 dark:bg-violet-900/30 dark:text-violet-300">
                                    {{ $credit->role }}
                                </span>
                            </td>
                            <td class="hidden px-4 py-3 text-sm text-zinc-500 md:table-cell">{{ $credit->artist ?? '—' }}</td>
                            <td class="hidden px-4 py-3 text-sm text-zinc-500 lg:table-cell">{{ $credit->label ?? '—' }}</td>
                            <td class="px-4 py-3 text-center text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $credit->year ?? '—' }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button wire:click="openForm({{ $credit->id }})"
                                            class="rounded p-1.5 text-zinc-400 hover:text-zinc-600 transition">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <button wire:click="deleteCredit({{ $credit->id }})"
                                            wire:confirm="Delete this credit?"
                                            class="rounded p-1.5 text-zinc-300 hover:text-red-400 transition">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <p class="text-xs text-zinc-400">
            {{ $credits->count() }} {{ Str::plural('credit', $credits->count()) }} · Export as PDF to share with publishers and supervisors.
        </p>
    @endif

</div>
