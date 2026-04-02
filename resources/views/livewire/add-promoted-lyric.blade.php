<div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
    <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-6">

        <h1 class="text-2xl font-bold mb-2">Add Promoted Lyric</h1>
        <p class="text-sm text-gray-500 mb-6">Enter the <code>client_reference_id</code> string, e.g. <code>pro-1847-7085-5-Classical-2</code></p>

        @if (session()->has('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif

        <form wire:submit.prevent="submit">
            <div class="mb-4">
                <label class="block font-semibold mb-1">client_reference_id</label>
                <input
                    type="text"
                    wire:model.defer="client_reference_id"
                    placeholder="pro-{user_id}-{lyric_id}-{bid}-{placement}-{duration}"
                    class="w-full border px-3 py-2 rounded font-mono"
                >
                @error('client_reference_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
            >
                Add Promotion
            </button>
        </form>
    </div>
</div>
