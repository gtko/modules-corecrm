<div>

    @can('create', \Modules\CoreCRM\Models\Document::class)
    <form method="POST" wire:submit.prevent="store" class="mt-5"
          x-data="{ isUploading: false, progress: 0 }"
          x-on:livewire-upload-start="isUploading = true"
          x-on:livewire-upload-finish="isUploading = false"
          x-on:livewire-upload-error="isUploading = false"
          x-on:livewire-upload-progress="progress = $event.detail.progress">
        <div class="grid grid-cols-8 gap-2">
            <input type="file" id="document" wire:model.defer="file" class="col-span-4 form-control form-control-sm">
            <x-basecore::inputs.text name="title" wire:model.defer="title"
                                     class="col-span-4 form-control form-control-sm"
                                     placeholder="Nom du fichier">Nom du document
            </x-basecore::inputs.text>

        </div>
        <div class="grid-cols-8 gap-2">
            <div x-show="isUploading" class="col-span-8 w-full my-2">
                <progress max="100" x-bind:value="progress" class="col-span-8 w-full"></progress>
            </div>
            <x-basecore::button type="submit" class="mt-2 btn-sm">Sauvegarder</x-basecore::button>
        </div>

        <form/>
    @endcan


    <livewire:corecrm::document-list dossier-id="{{$this->dossier->id}}"/>

    @push('scripts')
        <script>
            Livewire.on('documentAdd', () => {
                document.getElementById("document").value = null;
            });
        </script>
    @endpush

</div>
