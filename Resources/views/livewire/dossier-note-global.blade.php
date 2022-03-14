<div class="col-span-12 md:col-span-6 xxl:col-span-12 mt-3 xxl:mt-6">
    <div class="intro-x flex items-center h-10">
        <h2 class="text-lg font-medium truncate mr-5">A retenir</h2>
    </div>
    <x-basecore::inputs.wysiwyg name="note_global" :label="''" :value="$note_global" :livewire="true"/>
    <button wire:click="store" class="btn btn-primary mt-4">Sauvegarder</button>
</div>
