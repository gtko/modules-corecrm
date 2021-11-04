<x-basecore::app-layout>

    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item :href="route('dossiers.index')">Clients</x-basecore::breadcrumb-item>
        <x-basecore::breadcrumb-item>{{$client->format_name}}</x-basecore::breadcrumb-item>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.clients.show_title')
        </h2>
    </x-slot>

    <x-basecore::nav.nav-layout :default="'dossier'">
        <x-basecore::personne.header :personne="$client">
            <x-slot name="title">
                Client détails
            </x-slot>

            <x-slot name="details">
                <div class="text-gray-600">Client créé le {{ $client->created_at->format('d-m-Y') }}</div>
            </x-slot>

            <x-basecore::nav.menu>
                <x-basecore::nav.menu-item :name="'dossier'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user w-4 h-4 mr-2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    Dossiers
                </x-basecore::nav.menu-item>
                <x-basecore::nav.menu-item :name="'editer'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shield w-4 h-4 mr-2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    Editer le client
                </x-basecore::nav.menu-item>
            </x-basecore::nav.menu>
        </x-basecore::personne.header>

        <x-basecore::nav.tab :name="'dossier'">
{{--            <x-data-list :title="'Les dossiers client'"--}}
{{--                         :datas="$dossiers"--}}
{{--                         :type="(new App\DataListTypes\DossierDataList())"--}}
{{--                         :parents="[$client]"--}}
{{--            />--}}
            <livewire:datalistcrm::data-list :title="'Les fiches similaires'"
                                :type="Modules\CoreCRM\DataLists\DossierDataList::class"
                                :parents="[$client->id]"
            />
        </x-basecore::nav.tab>

        <x-basecore::nav.tab :name="'editer'">
            <x-basecore::layout.panel-left>
                <x-basecore::partials.card>
                    <x-corecrm::client.form :client="$client"/>
                </x-basecore::partials.card>
            </x-basecore::layout.panel-left>
        </x-basecore::nav.tab>

    </x-basecore::nav.nav-layout>
</x-basecore::app-layout>
