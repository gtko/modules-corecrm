<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item>Workflow</x-basecore::breadcrumb-item>
    </x-slot>
    <x-basecore::layout.panel-full>
        <livewire:datalistcrm::data-list :title="'Workflow'" :type="Modules\CoreCRM\DataLists\WorkflowDataList::class"/>
    </x-basecore::layout.panel-full>
</x-basecore::app-layout>
