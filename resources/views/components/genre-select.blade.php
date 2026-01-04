<div class="mb-4">
    <label for="genre" class="block font-semibold mb-1">Genre</label>

    <select
        id="genre"
        wire:model.defer="{{ $model }}"
        class="w-full border px-3 py-2 rounded"
    >
        <option value="">Select:</option>
        @foreach ($genres as $genre)
            <option value="{{ $genre }}">{{ $genre }}</option>
        @endforeach
    </select>

    @error($model)
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>
