@props([
   'param',
   'model',
   'instance',
])

@php
    $label = $param->name();
    $name = 'subject'
@endphp
<div class="mt-3">
    @if($label ?? null)
        @include('basecore::components.inputs.partials.label')
    @endif

    <div x-data="{open:false}">

           <div class="grid grid-cols-1 gap-2">
               <input wire:model="{{$model}}.email" placeholder="email a qui envoyé séparé par une virgule ,"
                      type="text" class="form-control block appearance-none w-full text-gray-800 border rounded dark:text-white">
               <input wire:model="{{$model}}.url" placeholder="Lien url"
                      type="text" class="form-control block appearance-none w-full text-gray-800 border rounded dark:text-white">
               <input wire:model="{{$model}}.image" placeholder="image"
                      type="text" class="form-control block appearance-none w-full text-gray-800 border rounded dark:text-white">
               <input wire:model="{{$model}}.title" placeholder="Titre"
                      type="text" class="form-control block appearance-none w-full text-gray-800 border rounded dark:text-white">
               <textarea rows="15" name="content" id="message"
                         class="block w-full rounded border-gray-400 border-1 py-3 resize-none placeholder-gray-500 focus:ring-0 sm:text-sm"
                         placeholder="Message"
                         autocomplete="off"
                         wire:model="{{$model}}.content"
               ></textarea>
           </div>
    </div>
</div>
