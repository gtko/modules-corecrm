@props([
   'param',
   'model'
])

@php
    $label = $param->name();
    $name = 'subject'
@endphp
@if($label ?? null)
    @include('basecore::components.inputs.partials.label')
@endif

<div class="border-2 border-dashed border-gray-200 p-4">
<x-basecore::inputs.group>
    <x-basecore::inputs.text
        name="subject"
        label="Subject"
        wire:model="{{$model}}.subject"
        required="required"
    />
</x-basecore::inputs.group>
<x-basecore::inputs.group>
    <x-basecore::inputs.text
        name="cc"
        label="CC"
        wire:model="{{$model}}.cc"
        required="required"
    />
</x-basecore::inputs.group>
<x-basecore::inputs.group>
    <x-basecore::inputs.text
        name="cci"
        label="CCI"
        wire:model="{{$model}}.cci"
        required="required"
    />
</x-basecore::inputs.group>
<x-basecore::inputs.group>
    <x-basecore::inputs.textarea
        name="content"
        label="Content"
        wire:model="{{$model}}.content"
        required="required"
    />
</x-basecore::inputs.group>
</div>
