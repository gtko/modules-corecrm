<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item :href="route('workflows.index')">Workflow</x-basecore::breadcrumb-item>
        <x-basecore::breadcrumb-item>{{$workflow->name}}</x-basecore::breadcrumb-item>
        <x-basecore::breadcrumb-item>edit</x-basecore::breadcrumb-item>
    </x-slot>
    <x-basecore::layout.panel-left>
        <livewire:corecrm::workflow-form :workflow="$workflow"/>
    </x-basecore::layout.panel-left>

</x-basecore::app-layout>
