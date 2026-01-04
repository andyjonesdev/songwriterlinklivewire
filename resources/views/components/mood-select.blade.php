<div class="mb-4">
    <label for="mood" class="block font-semibold mb-1">Mood</label>

    <select
        id="mood"
        wire:model.defer="{{ $model }}"
        class="w-full border p-2 rounded"
    >
        <option value="">Select mood</option>

        @foreach ($moods as $mood)
            <option value="{{ $mood }}">{{ $mood }}</option>
        @endforeach
    </select>

    @error($model)
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>
