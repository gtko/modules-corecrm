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
                <div class="border-t border-gray-200 dark:border-dark-5">
                    <div class="flex flex-col">
                        <div class="overflow-x-auto">
                            <div class="inline-block min-w-full align-middle">
                                <div class="overflow-hidden shadow-sm ring-1 ring-black ring-opacity-5">
                                    <table class="min-w-full divide-y divide-gray-300">
                                        <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="py-3.5 px-2 text-left text-sm font-semibold text-gray-900">
                                                Infos initiales
                                            </th>
                                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8">
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 bg-white">
                                        @foreach(collect($dossier->data)->only(config('corecrm.lead_info')) as $label => $value)
                                            @if(!is_array($value))
                                                <tr>
                                                    <td class="px-2">{{$label}}</td>
                                                    <td class="px-2">{{$value}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
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
