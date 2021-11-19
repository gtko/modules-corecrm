<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item>Pipeline</x-basecore::breadcrumb-item>
    </x-slot>
    <x-basecore::layout.panel-full>
        <livewire:datalistcrm::data-list :title="'Pipeline'" :type="Modules\CoreCRM\DataLists\PipelineDataList::class"/>
    </x-basecore::layout.panel-full>
</x-basecore::app-layout>
