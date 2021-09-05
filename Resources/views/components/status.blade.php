@props([
    'label',
    'color' => 'gray'
])
<div style="background-color:{{$color}}" {{ $attributes->merge(['class' => "py-1 px-2 rounded-full text-xs text-white cursor-pointer font-medium"]) }}>
    {{$label}}
</div>
