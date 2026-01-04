<div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
    <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-6">

        <h1 class="text-2xl font-bold mb-4">Upload New Blog Post</h1>

        @if (session()->has('success'))
            <div class="mb-4 text-green-600">
                {{ session('success') }}
            </div>
        @endif

        <form wire:submit.prevent="submit">

            <!-- Title -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">Title</label>
                <input
                    type="text"
                    wire:model.defer="title"
                    class="w-full border px-3 py-2 rounded"
                >
                @error('title') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">Description</label>
                <input
                    type="text"
                    wire:model.defer="description"
                    class="w-full border px-3 py-2 rounded"
                >
                @error('description') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <!-- Category -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">Category</label>
                <select
                    wire:model.defer="category"
                    class="w-full border px-3 py-2 rounded"
                >
                    <option value="">Select:</option>
                    <option value="Songwriting">Songwriting</option>
                    <option value="Music">Music</option>
                </select>
                @error('category') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <!-- Content -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">Blog Content</label>
                <textarea
                    wire:model.defer="content"
                    rows="24"
                    class="w-full border px-3 py-2 rounded"
                ></textarea>
                @error('content') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <!-- Submit -->
            <button
                type="submit"
                wire:loading.attr="disabled"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 my-6"
            >
                Upload Blog
            </button>
        </form>
    </div>
</div>
