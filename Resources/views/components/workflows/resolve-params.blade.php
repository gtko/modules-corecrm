@props([
   'param',
   'model'
])

<x-dynamic-component :component="$param->nameView()"
                     :attributes="new Illuminate\View\ComponentAttributeBag([
                     'param' => $param,
                     'model' => $model
                 ])"
/>
