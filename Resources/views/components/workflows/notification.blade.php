@props([
   'param',
   'model',
   'instance'
])

@php
    $label = $param->name();
    $name = 'subject'
@endphp
@if($label ?? null)
    @include('basecore::components.inputs.partials.label')
@endif

<div x-data="{open:false}">
    <span x-on:click="open=true" class="btn btn-primary">Editer email</span>

    <div x-show='open' class="fixed z-40 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-transparent border-0 p-1 text-left overflow-hidden transform transition-all sm:my-4 sm:align-middle sm:max-w-4xl sm:w-full">
                <div>
                    <div class="relative border bg-white border-gray-300 rounded-lg shadow-xl overflow-hidden focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500">
                        <label for="sujet" class="sr-only">Sujet</label>
                        <input type="text" name="sujet" id="sujet"
                               class="block w-full border-0 pt-2.5 text-lg font-medium placeholder-gray-500 focus:ring-0"
                               placeholder="Sujet"
                               autocomplete="off"
                               wire:model="{{$model}}.subject"
                        >
                        <label for="cc" class="sr-only">Pour</label>
                        <input type="text" name="cc" id="cc"
                               class="block w-full border-0 pt-2.5 text-lg font-medium placeholder-gray-500 focus:ring-0"
                               placeholder="email@dudestinataire.com"
                               autocomplete="off"
                               wire:model="{{$model}}.cc"
                        >
                        <label for="sujet" class="sr-only">Autre destinataire</label>
                        <input type="text" name="cci" id="cci"
                               class="block w-full border-0 pt-2.5 text-lg font-medium placeholder-gray-500 focus:ring-0"
                               placeholder="destinataire1gmail.com, destinataire2@gmail.com"
                               autocomplete="off"
                               wire:model="{{$model}}.cci"
                        >
                        <label for="description" class="sr-only">Description</label>
                        <textarea rows="15" name="description" id="description"
                                  class="block w-full border-0 py-0 resize-none placeholder-gray-500 focus:ring-0 sm:text-sm"
                                  placeholder="Contenu de l'email"
                                  autocomplete="off"
                                  wire:model="{{$model}}.content"
                        ></textarea>

                        <div aria-hidden="true">
                            <div class="py-2">
                                <div class="py-px">
                                    <div class="h-9"></div>
                                </div>
                            </div>
                        </div>
                        <div class="absolute bottom-0 inset-x-px" x-data="{
                            files : $wire.get('{{$model}}.files'),
                            add(object){
                                this.files.push(object)
                                $wire.set('{{$model}}.files', this.files)
                            },
                            remove(id){
                                this.files = this.files.filter((item) => {
                                    return item.class !== id
                                });
                            },
                            notAdded(id){
                                if(!this.files) this.files = []
                                return this.files.filter((item) => {
                                    return item.class === id
                                }).length < 1;
                            }
                        }">
                            <!-- Actions: These are just examples to demonstrate the concept, replace/wire these up however makes sense for your project. -->
                            <div class="flex flex-nowrap justify-end py-2 px-2 space-x-2 sm:px-3">
                                <template x-for="file in files">
                                    <span class="hover:bg-red-200 hover:text-red-800 cursor-pointer inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800 mr-1"
                                        x-on:click="remove(file.class)"
                                    >
                                        @icon('document', 12, 'mr-1')
                                        <span x-text="file.name"></span>
                                    </span>
                                </template>
                            </div>
                            <div class="border-t border-gray-200 px-2 py-2 flex justify-between items-center space-x-3 sm:px-3">
                                <div class="flex">
                                    <span type="button" class="-ml-2 -my-2 rounded-full px-3 py-2 inline-flex items-center text-left text-gray-400 group">
                                        <!-- Heroicon name: solid/paper-clip -->
                                        <svg class="-ml-1 h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-sm text-gray-500 italic">Attacher un fichier</span>
                                    </span>
                                    @foreach($instance->event->files() as $index => $file)
                                        <span class="hover:bg-blue-200 hover:text-blue-800 cursor-pointer inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-gray-100 text-gray-800 mr-1"
                                            x-on:click="add({'name' : '{{$file->name()}}', 'class' : '{{base64_encode($file::class)}}' })"
                                            x-show="notAdded('{{base64_encode($file::class)}}')"
                                        >
                                            {{$file->name()}}
                                        </span>
                                    @endforeach
                                </div>
                                <div class="flex-shrink-0">
                                <span x-on:click='open=false' class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Valider
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
