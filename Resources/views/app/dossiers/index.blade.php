<x-basecore::app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.dossiers.index_title')
        </h2>
    </x-slot>


    <livewire:datalistcrm::data-list :title="'Les clients'"
                                     :type="Modules\CoreCRM\DataLists\DossierDataList::class"
    />


</x-basecore::app-layout>
