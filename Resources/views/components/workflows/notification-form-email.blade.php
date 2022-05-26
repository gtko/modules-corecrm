@props([
   'model',
   'instance',
])

<label for="sujet" class="block font-bold mt-2 mb-1">Sujet</label>
<input type="text" name="sujet" id="sujet"
       class="block w-full rounded border-gray-400 border-1 pt-2.5 text-lg font-medium placeholder-gray-500 focus:ring-0"
       placeholder="Sujet"
       autocomplete="off"
       wire:model="{{$model}}.subject"
>
<label for="cc" class="block font-bold mt-2 mb-1">Pour</label>
<input type="text" name="cc" id="cc"
       class="block w-full rounded border-gray-400 border-1 pt-2.5 text-lg font-medium placeholder-gray-500 focus:ring-0"
       placeholder="email@dudestinataire.com"
       autocomplete="off"
       wire:model="{{$model}}.cc"
>
<label for="sujet" class="block font-bold mt-2 mb-1">Autre destinataire</label>
<input type="text" name="cci" id="cci"
       class="block w-full rounded border-gray-400 border-1 pt-2.5 text-lg font-medium placeholder-gray-500 focus:ring-0"
       placeholder="destinataire1gmail.com, destinataire2@gmail.com"
       autocomplete="off"
       wire:model="{{$model}}.cci"
>
<label for="from" class="block font-bold mt-2 mb-1">Expéditeur</label>
<input type="text" name="from" id="from"
       class="block w-full rounded border-gray-400 border-1 pt-2.5 text-lg font-medium placeholder-gray-500 focus:ring-0"
       placeholder="{{config('mail.from.address')}}"
       autocomplete="off"
       wire:model="{{$model}}.from"
>
<label for="from_name" class="block font-bold mt-2 mb-1">Nom de l'expéditeur</label>
<input type="text" name="from_name" id="from_name"
       class="block w-full rounded border-gray-400 border-1 pt-2.5 text-lg font-medium placeholder-gray-500 focus:ring-0"
       placeholder="{{config('mail.from.name')}}"
       autocomplete="off"
       wire:model="{{$model}}.from_name"
>
<label for="description" class="block font-bold mt-2 mb-1">Contenu de l'email</label>
<textarea rows="15" name="description" id="description"
          class="block w-full rounded border-gray-400 border-1 py-3 resize-none placeholder-gray-500 focus:ring-0 sm:text-sm"
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
<div class="absolute bottom-0 inset-x-px"  wire:model="{{$model}}.files" x-data="{
    files : $wire.get('{{$model}}.files'),
    add(object){
        this.files.push(object)
        $dispatch('input', this.files)
    },
    remove(id){
        this.files = this.files.filter((item) => {
            return item.class !== id
        });
        $dispatch('input', this.files)
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
            <x-buk-dropdown class="relative inline-block text-left">
                <x-slot name="trigger">
                    <span class="cursor-pointer inline-flex justify-center items-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500">
                        <x-heroicon-o-link class="h-4 w-4 mr-2"/> Attacher un fichier
                    </span>
                </x-slot>
                <div class="origin-bottom-left bottom-0 mb-12 absolute left-0 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                @foreach($instance->event->files() as $index => $file)
                    <span class="cursor-pointer text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100 hover:text-gray-900"
                          x-on:click="add({'name' : '{{$file->name()}}', 'class' : '{{base64_encode($file::class)}}' })"
                          x-show="notAdded('{{base64_encode($file::class)}}')"
                    >
                        {{$file->name()}}
                    </span>
                @endforeach
                </div>
            </x-buk-dropdown>
        </div>
        <div class="flex-shrink-0">
            {{ $slot }}
        </div>
    </div>
</div>
