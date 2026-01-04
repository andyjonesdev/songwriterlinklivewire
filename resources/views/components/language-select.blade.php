<div class="mb-4">
    <label for="language" class="block font-semibold mb-1">Language</label>

    <select
        id="language"
        wire:model.defer="{{ $model }}"
        class="w-full border p-2 rounded"
    >
        <option value="">Select language</option>

        @foreach ($languages as $language)
            <option value="{{ $language }}">{{ $language }}</option>
        @endforeach
    </select>

    @error($model)
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>
