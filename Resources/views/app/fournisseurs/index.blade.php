<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item>Fournisseurs</x-basecore::breadcrumb-item>
    </x-slot>
    <livewire:datalistcrm::data-list :title="'Fournisseur'" :type="\Modules\CoreCRM\DataLists\FournisseurDataList::class"/>
</x-basecore::app-layout>
