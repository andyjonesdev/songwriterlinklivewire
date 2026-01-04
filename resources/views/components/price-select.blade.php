<div class="mb-4">
    <label for="price" class="block font-semibold mb-1">Price ($)</label>

    <select
        id="price"
        wire:model.defer="{{ $model }}"
        class="w-full border p-2 rounded"
    >
        <option value="">Select price</option>

        @foreach ($prices as $price)
            <option value="{{ $price }}">{{ $price }}</option>
        @endforeach
    </select>

    @error($model)
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>
