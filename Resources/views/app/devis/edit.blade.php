<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item :href="route('dossiers.index')">Clients</x-basecore::breadcrumb-item>
        <x-basecore::breadcrumb-item :href="route('clients.show', $client)">{{$client->format_name}}</x-basecore::breadcrumb-item>
        <x-basecore::breadcrumb-item :href="route('dossiers.show',[$client, $dossier])">dossier#{{$dossier->ref}}</x-basecore::breadcrumb-item>
        <x-basecore::breadcrumb-item>devis#{{$devi->ref}}</x-basecore::breadcrumb-item>
    </x-slot>

    <x-basecore::layout.panel-sidebar>
        <x-slot name="sidebar">
            <x-corecrm::client.sidebar :client="$devi->dossier->client" :dossier="$dossier">
                <x-slot name="status">
                    <x-corecrm::status :label="$devi->dossier->status_label"/>
                </x-slot>
                <x-slot name="actions">
                    <div class="flex flex-col w-full ">
                        <a href="" class="w-full btn btn-primary py-1 px-2 ml-auto mb-2 ignore-link">Envoyer le devis</a>
                        <x-corecrm::link-devis
                            :devis="$devi"
                            class="w-full btn btn-outline-secondary py-1 px-2 ml-auto mb-2 ignore-link"
                        >
                            Voir le devis
                        </x-corecrm::link-devis>
                        <a href="" class="w-full btn btn-outline-secondary py-1 px-2 ml-auto mb-2">Envoyer aux fournisseur</a>
                        <a href="{{route('clients.edit', $devi->dossier->client)}}" class="w-full btn  btn-outline-secondary py-1 px-2 mb-2">Éditer le client</a>
                    </div>
                </x-slot>
            </x-corecrm::client.sidebar>
{{--            <livewire:corecrm::timeline :dossier="$devi->dossier->id"/>--}}

        </x-slot>

        <x-basecore::resolve-type-view
            :contrat-view-class="\Modules\CoreCRM\Contracts\Views\DevisEditViewContract::class"
            :arguments="['client' => $client, 'dossier' => $dossier, 'devis' => $devi]"
        />
    </x-basecore::layout.panel-sidebar>
</x-basecore::app-layout>
