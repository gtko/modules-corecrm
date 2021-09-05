@php $editing = isset($source) @endphp

<div class="flex flex-wrap">
    <x-basecore::inputs.group class="w-full">
        <x-basecore::inputs.text
            name="label"
            label="Label"
            value="{{ old('label', ($editing ? $source->label : '')) }}"
            maxlength="255"
            required
        ></x-basecore::inputs.text>
    </x-basecore::inputs.group>
</div>
