<div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">

    <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-6">
        <h1 class="text-2xl font-bold mb-4">Edit Profile</h1>

        <form wire:submit.prevent="updateProfile">
            <!-- Bio -->
            <div class="mb-4">
                <label for="bio" class="block font-semibold mb-1">Bio</label>
                <textarea
                    id="bio"
                    rows="24"
                    class="w-full border px-3 py-2 rounded"
                    wire:model.defer="bio"
                ></textarea>
                @error('bio') 
                    <p class="text-red-500 text-sm">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Submit -->
            <button
                type="submit"
                class="rounded-sm bg-[#e8363c] px-5 py-2 text-lg leading-normal text-white hover:border-black 
                hover:bg-black dark:border-[#e8363c] dark:bg-[#e8363c] dark:text-[#1C1C1A] 
                dark:hover:border-white dark:hover:bg-white"
            >
                Update
            </button>

            @if (session()->has('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded my-4">
                    Your profile has been updated successfully!
                </div>
            @endif
        </form>
    </div>
</div>

<script>
    // Optional: hide success message after 3 seconds
    window.addEventListener('clear-updated-message', event => {
        setTimeout(() => {
            Livewire.emit('refreshComponent'); // optional refresh
        }, event.detail.timeout);
    });
</script>
