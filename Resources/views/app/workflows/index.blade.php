<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item>Workflow</x-basecore::breadcrumb-item>
    </x-slot>
    <x-basecore::layout.panel-full>
        <div class="flex flex-wrap justify-between sm:flex-nowrap items-center mt-2">
            <a href="{{route('workflows.create')}}" class="btn btn-primary shadow-md mr-2">
                @icon('addCircle', null, 'mr-2') Nouveau workflow
            </a>
        </div>
        <livewire:corecrm::workflow-datatable />
    </x-basecore::layout.panel-full>
</x-basecore::app-layout>
