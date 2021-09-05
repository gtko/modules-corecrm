<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item>Statuts</x-basecore::breadcrumb-item>
    </x-slot>
    <x-basecore::layout.panel-full>
        <livewire:datalistcrm::data-list :title="'Status'" :type="Modules\CoreCRM\DataLists\StatusDataList::class"/>
    </x-basecore::layout.panel-full>
</x-basecore::app-layout>
