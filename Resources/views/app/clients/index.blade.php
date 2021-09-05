<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item>Clients</x-basecore::breadcrumb-item>
    </x-slot>


    <livewire:datalistcrm::data-list :title="'Clients'" :type="Modules\CoreCRM\DataLists\ClientDataList::class"/>

</x-basecore::app-layout>
