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
               <input wire:model="{{$model}}.titre" placeholder="Titre"
                      type="text" class="form-control block appearance-none w-full text-gray-800 border rounded dark:text-white">

               <textarea rows="15" name="message" id="message"
                         class="block w-full rounded border-gray-400 border-1 py-3 resize-none placeholder-gray-500 focus:ring-0 sm:text-sm"
                         placeholder="Contenu de la card"
                         autocomplete="off"
                         wire:model="{{$model}}.message"
               ></textarea>
           </div>
    </div>
</div>
