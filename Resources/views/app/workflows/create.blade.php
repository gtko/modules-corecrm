<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item :href="route('workflows.index')">Workflow</x-basecore::breadcrumb-item>
        <x-basecore::breadcrumb-item>Create</x-basecore::breadcrumb-item>
    </x-slot>
    <x-basecore::layout.panel-left>
        <livewire:corecrm::workflow-form/>
    </x-basecore::layout.panel-left>

</x-basecore::app-layout>
