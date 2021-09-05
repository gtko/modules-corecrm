<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item>Sources</x-basecore::breadcrumb-item>
    </x-slot>
    <x-basecore::layout.panel-full>
        <livewire:datalistcrm::data-list :title="'Sources'" :type="Modules\CoreCRM\DataLists\SourceDataList::class"/>
    </x-basecore::layout.panel-full>
</x-basecore::app-layout>
