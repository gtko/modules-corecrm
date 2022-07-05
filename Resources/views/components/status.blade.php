@props([
    'label',
    'color' => 'gray'
])
@php
if($color == '')
    {
        $color = 'gray';
    }
@endphp

<div style="background-color:{{$color}}" {{ $attributes->merge(['class' => "py-1 px-2 rounded text-xs text-white cursor-pointer font-medium text-center"]) }}>
    {{$label}}
</div>
