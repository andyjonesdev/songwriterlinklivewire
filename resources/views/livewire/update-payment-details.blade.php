<div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">

    <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-6">
        <h2 class="text-2xl mb-8">Your Payment Details</h2>

        <form wire:submit.prevent="submit">
            <!-- PayPal Email -->
            <div class="mb-4">
                <label for="paypal_email" class="block font-semibold mb-1">PayPal Email</label>
                <input
                    type="email"
                    id="paypal_email"
                    wire:model.defer="paypal_email"
                    class="w-full border px-3 py-2 rounded"
                >
                @error('paypal_email')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <button
                type="submit"
                class="rounded-sm border bg-[#e8363c] px-5 py-2 text-lg leading-normal text-white hover:border-black 
                    hover:bg-black dark:border-[#e8363c] dark:bg-[#e8363c] dark:text-[#1C1C1A] 
                    dark:hover:border-white dark:hover:bg-white"
            >
                Update
            </button>

            @if (session()->has('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded my-4">
                    Your payment details have been updated successfully!
                </div>
            @endif
        </form>
    </div>
</div>

{{-- Optional JS to hide the success message after 3s --}}
<script>
    window.addEventListener('hide-success-message', event => {
        setTimeout(() => {
            const el = document.getElementById('success-message');
            if (el) el.remove();
        }, event.detail.delay);
    });
</script>
