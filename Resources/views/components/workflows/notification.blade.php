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

           <div class="grid grid-cols-2 gap-2">
               <input wire:model="{{$model}}.subject" placeholder="sujet de l'email"
                      type="text" class="col-span-2 form-control block appearance-none w-full text-gray-800 border rounded dark:text-white">
                <input wire:model="{{$model}}.delay_min" placeholder="delay minimum (minutes)"
                       type="number" class="form-control block appearance-none w-full text-gray-800 border rounded dark:text-white">
               <select wire:model="{{$model}}.template" class="form-control block appearance-none w-full text-gray-800 border rounded dark:text-white">
                   @foreach(app(Modules\CoreCRM\Flow\Works\Services\TemplateMailService::class)->all() as $name => $template)
                       <option value="{{$name}}">Template email {{Illuminate\Support\Str::ucfirst($name)}}</option>
                   @endforeach
               </select>
                <input wire:model="{{$model}}.delay_max" placeholder="delay maximum (minutes)"
                       type="number" class="form-control block appearance-none w-full text-gray-800 border rounded dark:text-white">
                <span x-on:click="open=true" class="btn btn-primary">Editer email</span>
           </div>

        <div x-show='open' x-cloak style='z-index:900' class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-transparent border-0 p-1 text-left overflow-hidden transform transition-all sm:my-4 sm:align-middle sm:max-w-4xl sm:w-full">
                    <div>
                        <div class="relative border bg-white p-4 border-gray-300 rounded-lg shadow-xl overflow-hidden focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500">
                            <x-corecrm::workflows.notification-form-email
                                :instance="$instance"
                                :model="$model"
                            >
                                  <span x-on:click='open=false' class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Valider
                                </span>
                            </x-corecrm::workflows.notification-form-email>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
