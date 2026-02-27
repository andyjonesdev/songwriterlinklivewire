<div class="mt-6 rounded-lg border border-gray-200 bg-gray-50 p-4">
    <label class="flex items-start gap-3 cursor-pointer">
        <input
            type="checkbox"
            wire:model.live="allowMarketing"
            class="mt-1 h-5 w-5 rounded border-gray-300 text-[#e8363c] 
                   focus:ring-[#e8363c] dark:border-neutral-600 dark:bg-neutral-800"
        />

        <div class="text-sm leading-relaxed text-gray-700 dark:text-gray-300">
            <span class="font-medium text-gray-900 dark:text-white">
                Allow marketing promotion
            </span>
            <p class="mt-1">
                You give us permission to send you marketing emails about lyric contests etc.
            </p>
        </div>
    </label>

    <!-- <div
        wire:loading
        class="mt-2 text-xs text-gray-500"
    >
        Saving…
    </div> -->
</div>
