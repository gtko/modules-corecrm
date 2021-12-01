@props([
   'param',
   'model'
])
<x-basecore::inputs.group>
    <x-basecore::inputs.number
        name="name"
        label="{{$param->name()}}"
        wire:model="{{$model}}"
        required="required"
    />
</x-basecore::inputs.group>