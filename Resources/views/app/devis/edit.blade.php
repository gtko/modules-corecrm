<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item :href="route('dossiers.index')">Clients</x-basecore::breadcrumb-item>
        <x-basecore::breadcrumb-item :href="route('clients.show', $client)">{{$client->format_name}}</x-basecore::breadcrumb-item>
        <x-basecore::breadcrumb-item :href="route('dossiers.show',[$client, $dossier])">dossier#{{$dossier->ref}}</x-basecore::breadcrumb-item>
        <x-basecore::breadcrumb-item>devis#{{$devi->ref}}</x-basecore::breadcrumb-item>
    </x-slot>

    <x-basecore::layout.panel-sidebar>
        <x-slot name="sidebar">
            <div class="bg-white p-4 mb-2 rounded">
            <div class="relative flex items-center p-5">
                <div class="w-12 h-12 image-fit">
                    <x-basecore::avatar :url="$client->avatar_url"/>
                </div>
                <div class="ml-4 mr-auto">
                    <div class="font-medium text-base">{{$client->format_name}}</div>
                </div>
            </div>
            <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                <x-basecore::personne.address-details :personne="$client"/>
            </div>
            </div>
            <livewire:corecrm::timeline :dossier="$devi->dossier->id" :inverse="true"/>
        </x-slot>

        <x-basecore::resolve-type-view
            :contrat-view-class="\Modules\CoreCRM\Contracts\Views\DevisEditViewContract::class"
            :arguments="['client' => $client, 'dossier' => $dossier, 'devis' => $devi]"
        />
    </x-basecore::layout.panel-sidebar>
</x-basecore::app-layout>
