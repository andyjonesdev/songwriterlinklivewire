<button
    wire:click="toggleSave"
    wire:loading.attr="disabled"
    class="rounded-sm bg-[#e8363c] px-5 py-1 my-1 text-lg text-white hover:bg-black cursor-pointer
           {{ $isSaved ? 'bg-green-600 text-white' : 'bg-[#e8363c] text-white' }}"
>
    @if($isSaved)
        <i class="fa-solid fa-check"></i> Saved
    @else
        <i class="fa-solid fa-plus"></i> Save
    @endif
</button>