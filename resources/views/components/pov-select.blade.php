<div class="mb-4">
    <label for="pov" class="block font-semibold mb-1">Point-of-View</label>

    <select
        id="pov"
        wire:model.defer="{{ $model }}"
        class="w-full border p-2 rounded"
    >
        <option value="">Select pov</option>

        @foreach ($povs as $pov)
            <option value="{{ $pov }}">{{ $pov }}</option>
        @endforeach
    </select>

    @error($model)
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>
