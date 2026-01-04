<div class="mb-4">
    <label for="theme" class="block font-semibold mb-1">Theme</label>

    <select
        id="theme"
        wire:model.defer="{{ $model }}"
        class="w-full border p-2 rounded"
    >
        <option value="">Select theme</option>

        @foreach ($themes as $theme)
            <option value="{{ $theme }}">{{ $theme }}</option>
        @endforeach
    </select>

    @error($model)
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>
