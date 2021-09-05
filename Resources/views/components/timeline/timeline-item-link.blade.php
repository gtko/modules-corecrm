@props([
    'url',
])
<a class='text-blue-700' href="{{$url}}">
    {{$slot ?? ''}}
</a>
