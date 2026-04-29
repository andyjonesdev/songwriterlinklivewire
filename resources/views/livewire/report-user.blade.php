<div>
    @if($submitted)
        <p class="text-xs text-zinc-400 italic">Report submitted — thank you.</p>
    @else
        <button wire:click="$set('open', true)"
                class="flex items-center gap-1 text-xs text-zinc-400 hover:text-red-500 transition-colors">
            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/></svg>
            Report member
        </button>
    @endif

    @if($open)
        {{-- Modal backdrop --}}
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div wire:click="$set('open', false)" class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
            <div class="relative z-10 w-full max-w-md rounded-xl border border-zinc-200 bg-white p-6 shadow-xl space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-semibold text-zinc-900">Report this member</h3>
                    <button wire:click="$set('open', false)" class="text-zinc-400 hover:text-zinc-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <p class="text-sm text-zinc-500">Your report will be reviewed by our team. Abuse of this system may result in action against your own account.</p>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-zinc-700">Reason <span class="text-red-500">*</span></label>
                    <select wire:model="reason"
                            class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2.5 text-sm text-zinc-700 focus:border-violet-400 focus:outline-none focus:ring-2 focus:ring-violet-100">
                        <option value="">Select a reason…</option>
                        @foreach($reasons as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('reason') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-zinc-700">Details <span class="text-zinc-400 font-normal">(optional)</span></label>
                    <textarea wire:model="detail" rows="3" maxlength="1000"
                              placeholder="Any additional context that might help our review…"
                              class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2.5 text-sm text-zinc-900 placeholder-zinc-400 focus:border-violet-400 focus:outline-none focus:ring-2 focus:ring-violet-100 resize-none"></textarea>
                </div>

                <div class="flex items-center gap-3 pt-1">
                    <button wire:click="submit" wire:loading.attr="disabled"
                            class="flex-1 rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-red-700 disabled:opacity-60 transition">
                        <span wire:loading.remove wire:target="submit">Submit report</span>
                        <span wire:loading wire:target="submit">Submitting…</span>
                    </button>
                    <button wire:click="$set('open', false)"
                            class="rounded-lg border border-zinc-200 px-4 py-2.5 text-sm font-medium text-zinc-600 hover:border-zinc-300 transition">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
