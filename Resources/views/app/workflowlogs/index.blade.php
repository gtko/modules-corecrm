<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item>Statuts</x-basecore::breadcrumb-item>
    </x-slot>
    <x-basecore::layout.panel-full>

    <livewire:corecrm::workflow-log-datatable />

    </x-basecore::layout.panel-full>
</x-basecore::app-layout>
