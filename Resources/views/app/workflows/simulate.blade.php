<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item :href="route('workflows.index')">Workflow</x-basecore::breadcrumb-item>
        <x-basecore::breadcrumb-item>{{$workflow->name}}</x-basecore::breadcrumb-item>
        <x-basecore::breadcrumb-item>Simulation</x-basecore::breadcrumb-item>
    </x-slot>
    <x-basecore::layout.panel-full>
        <livewire:corecrm::workflow-simulate :workflow="$workflow" />
    </x-basecore::layout.panel-full>

</x-basecore::app-layout>
