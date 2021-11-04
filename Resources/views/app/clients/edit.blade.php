<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item :href="route('dossiers.index')">Clients</x-basecore::breadcrumb-item>
        <x-basecore::breadcrumb-item
            :href="route('clients.show', $client)">{{$client->format_name}}</x-basecore::breadcrumb-item>
        <x-basecore::breadcrumb-item>Editer</x-basecore::breadcrumb-item>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.clients.edit_title')
        </h2>
    </x-slot>
    <x-basecore::layout.panel-left>
        <x-basecore::partials.card>
            <x-slot name="title">
                <a href="{{ route('clients.index') }}" class="mr-4"
                ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
            </x-slot>
            <x-corecrm::client.client-form :client="$client">
                <a href="{{ route('clients.index') }}" class="button">
                    <i
                        class="
                                    mr-1
                                    icon
                                    ion-md-return-left
                                    text-primary
                                "
                    ></i>
                    @lang('basecore::crud.common.back')
                </a>
            </x-corecrm::client.client-form>
        </x-basecore::partials.card>
    </x-basecore::layout.panel-left>
</x-basecore::app-layout>
