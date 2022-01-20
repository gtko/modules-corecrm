@props([
   'param',
   'model'
])
<x-basecore::inputs.group>
    <x-basecore::inputs.select
        name="{{$param->name()}}"
        label="{{$param->name()}}"
        wire:model="{{$model}}"
        required="required"
    >
        <option>Sélectionner</option>
        <option value="true">Vrai</option>
        <option value="false">Faux</option>
    </x-basecore::inputs.select>
</x-basecore::inputs.group>
