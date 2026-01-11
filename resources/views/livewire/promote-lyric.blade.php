<div class="flex flex-col gap-4">

    <h1 class="text-2xl font-bold">Promote Lyric</h1>

    <form wire:submit.prevent="update">

        {{-- Title --}}
        <div class="mb-4">
            <p class="block mb-1">Lyric: <b>{{ $title }}</b></p>
            <p class="block mb-1">Genre: <b>{{ $genre }}</b></p>
        </div>
        
        <p>Put your lyric at the top of the main 'Buy Lyrics' page.</p>
        <p class="my-4">For a small cost, your lyric will appear at the top of the list for one month.</p>
        <p class="block mb-1">Price: <b>${{ 20 }}</b></p>
        {{-- Submit --}}
        <p class="my-4"><a
            href="https://buy.stripe.com/8x200c6Vofea9aP4Aebo401?prefilled_email={{ auth()->user()->email }}&client_reference_id=promote-{{ auth()->id() }}-{{ $lyric->id }}"
            class="mt-4 rounded-sm bg-[#e8363c] px-5 py-2 text-lg text-white hover:bg-black"
        >
            Buy Now
        </a></p>

        @if (session()->has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded my-4">
                {{ session('success') }}
            </div>
        @endif
    </form>

</div>
