<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item :href="route('statuses.index')">Pipeline</x-basecore::breadcrumb-item>
        <x-basecore::breadcrumb-item>{{$pipeline->name}}</x-basecore::breadcrumb-item>
        <x-basecore::breadcrumb-item>Edit</x-basecore::breadcrumb-item>
    </x-slot>
    <x-basecore::layout.panel-left>
        <livewire:corecrm::update-pipeline :pipeline="$pipeline"/>
    </x-basecore::layout.panel-left>

</x-basecore::app-layout>
