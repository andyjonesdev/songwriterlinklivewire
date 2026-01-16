<div class="flex flex-col gap-4">
    <h1 class="text-2xl font-bold">Promote Lyric</h1>
    <p class="my-4">Put your lyric at the top of the 'Buy Lyrics' page.</p>
    <form wire:submit.prevent="pay">

        {{-- Lyric Info --}}
        <div class="mb-4">
            <p class="block mb-1">Lyric: <b>{{ $lyric->title }}</b></p>
            <p class="block mb-1">Genre: <b>{{ $lyric->genre }}</b></p>
        </div>

        {{-- Bid --}}
        <label for="placement"><b>Placement</b></label><br />
        <select wire:model.live="placement" class="border rounded px-2 py-1 w-56 my-2" id="placement">
            <option value="">Select:</option>
            <option value="{{ $lyric->genre }}">{{ $lyric->genre }} Genre</option>
            <option value="all">All genres</option>
        </select>
        <p class="mb-2"><span class="text-red-600">@error('placement'){{$message}}@enderror</span></p>

        {{-- Bid --}}
        <label for="bid"><b>Bid</b></label><br />
        <select wire:model.live="bid" class="border rounded px-2 py-1 w-56 my-2" id="bid">
            <option value="5">$5</option>
            <option value="10">$10</option>
            <!-- <option value="20">$20</option> -->
        </select>
        <p class="mb-2"><span class="text-red-600">@error('bid'){{$message}}@enderror</span></p>

        {{-- Duration --}}
        <label for="duration"><b>Duration (weeks)</b></label><br />
        <select wire:model.live="duration" class="border rounded px-2 py-1 w-56" id="duration">
            <!-- <option value="1">1</option> -->
            <option value="2">2</option>
            <!-- <option value="3">3</option> -->
            <option value="4">4</option>
            <!-- <option value="5">5</option>
            <option value="6">6</option> -->
        </select>
        <p class="mb-2"><span class="text-red-600">@error('duration'){{$message}}@enderror</span></p>

        {{-- Reactive Estimated Cost --}}
        <div class="mb-4 mt-6">
            <p class="font-semibold">
                Estimated Cost: 
                <b>${{ number_format($this->estimatedCost, 2) }}</b>
            </p>
            <!-- <p class="text-sm text-gray-500">Cost = bid per week x number of weeks.</p> -->
        </div>

        {{-- Submit button --}}
        <button type="submit"
                class="mt-4 rounded-sm bg-[#e8363c] px-5 py-2 text-lg text-white hover:bg-black cursor-pointer">
            Promote Now
        </button>

    </form>
</div>
