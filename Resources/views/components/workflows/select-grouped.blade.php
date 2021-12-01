@props([
   'param',
   'model'
])
<x-basecore::inputs.group>
    <x-basecore::inputs.select
        name="name"
        label="{{$param->name()}}"
        wire:model="{{$model}}"
        required="required"
    >
        <option>Sélectionner un {{$param->name()}}</option>
        @foreach($param->getOptions()  as $options)
            @if($param->isGrouped())
                <optgroup label="{{$param->getFieldGroupeName($options)}}">
                    @foreach($param->getFieldGroupeValue($options) as $option)
                        <option value="{{$param->getFieldValue($option)}}">{{$param->getFieldLabel($option)}}</option>
                    @endforeach
                </optgroup>
            @else
                <option value="{{$param->getFieldValue($option)}}">{{$param->getFieldLabel($option)}}</option>
            @endif
        @endforeach
    </x-basecore::inputs.select>
</x-basecore::inputs.group>
