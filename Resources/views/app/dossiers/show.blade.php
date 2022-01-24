<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item :href="route('dossiers.index')">Clients</x-basecore::breadcrumb-item>
        <x-basecore::breadcrumb-item
            :href="route('clients.show', $client)">{{$client->format_name}}</x-basecore::breadcrumb-item>
        <x-basecore::breadcrumb-item>dossier#{{$dossier->ref}}</x-basecore::breadcrumb-item>
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.dossiers.show_title')
        </h2>
    </x-slot>

    <div class="mt-2">
        <livewire:corecrm::pipeline-steps :dossier="$dossier" />
    </div>
    <x-basecore::nav.layout default="{{$defaultName}}">
        <x-basecore::layout.panel-sidebar>
            <x-slot name="sidebar">
                <x-corecrm::client.sidebar :client="$client" :dossier="$dossier">
                    <x-slot name="status">
                            <x-corecrm::status :label="$dossier->status_label"/>
                    </x-slot>
                    <x-slot name="actions">

                        <x-basecore::resolve-type-view
                            :contrat-view-class="\Modules\CoreCRM\Contracts\Views\Dossiers\DossierSidebarActionsViewContract::class"
                            :arguments="['client' => $client, 'dossier' => $dossier]"
                        >
                            <div class="grid grid-cols-2 w-full gap-2 items-center justify-center">
                                <a href="{{route('clients.edit', $client)}}" class="btn btn-primary py-1 px-2 w-full">Éditer le
                                    client</a>
                                @can('create', Modules\CoreCRM\Models\Devi::class)
                                    <a href="{{route('devis.create', [$client, $dossier])}}"
                                       class="btn btn-outline-secondary py-1 px-2 w-full">Nouveau devis</a>
                                @endcan



                                <x-basecore::resolve-type-view
                                    :contrat-view-class="\Modules\CoreCRM\Contracts\Views\Dossiers\DossierSidebarAddActionsViewContract::class"
                                    :arguments="['client' => $client, 'dossier' => $dossier]"
                                />
                            </div>
                        </x-basecore::resolve-type-view>

                    </x-slot>

                </x-corecrm::client.sidebar>
                <x-basecore::resolve-type-view
                    :contrat-view-class="\Modules\CoreCRM\Contracts\Views\Dossiers\DossierAfterSidebarContract::class"
                    :arguments="['client' => $client, 'dossier' => $dossier]"
                />

            </x-slot>
            <x-basecore::partials.card>

                <x-basecore::nav.menu class="-mt-4">
                    @can('createNote', \Modules\CoreCRM\Models\Dossier::class)
                        <x-basecore::nav.menu-item name="note">
                            <x-basecore::icon-label icon="note" label="Note"/>
                        </x-basecore::nav.menu-item>
                    @endcan

                    @can('viewAny', \Modules\CoreCRM\Contracts\Entities\DevisEntities::class)
                        <x-basecore::nav.menu-item name="devis">
                            <x-basecore::icon-label icon="devis" label="Devis" :size="20"/>
                        </x-basecore::nav.menu-item>
                    @endcan

                    <x-basecore::resolve-type-view
                        :contrat-view-class="\Modules\CoreCRM\Contracts\Views\Dossiers\DossierTabLabelViewContract::class"
                        :arguments="['client' => $client, 'dossier' => $dossier]"
                    />

                    @if(in_array('call', config('corecrm.features')))
                        @can('viewAny', \Modules\CallCRM\Models\Appel::class)
                            <x-basecore::nav.menu-item name="call">
                                <x-basecore::icon-label icon="folder" label="Appels"/>
                            </x-basecore::nav.menu-item>
                        @endcan
                    @endif

                    @if(in_array('email', config('corecrm.features')))
                        @can('sendEmail', \Modules\CoreCRM\Models\Dossier::class)
                            <x-basecore::nav.menu-item name="email">
                                <x-basecore::icon-label icon="folder" label="Emails"/>
                            </x-basecore::nav.menu-item>
                        @endcan
                    @endif

                    @if(in_array('document', config('corecrm.features')))
                        @can('viewAny', \Modules\CoreCRM\Models\Document::class)
                            <x-basecore::nav.menu-item name="documents">
                                <x-basecore::icon-label icon="document" label="Documents"/>
                            </x-basecore::nav.menu-item>
                        @endcan
                    @endif



                </x-basecore::nav.menu>

                <x-basecore::nav.tab name="note">
                    <livewire:corecrm::note :dossier-id="$dossier->id" :client-id="$client->id"/>
                </x-basecore::nav.tab>


                <x-basecore::nav.tab name="devis">
                    <x-basecore::resolve-type-view
                        :contrat-view-class="\Modules\CoreCRM\Contracts\Views\Devis\DevisListContrat::class"
                        :arguments="['client' => $client, 'dossier' => $dossier, 'devis' => $devis]"
                    >
                        <div class="overflow-x-auto">
                            <table class="table mt-5">
                                <thead>
                                <tr class="text-gray-700">
                                    <th class="whitespace-nowrap" colspan="3">
                                        {{$devis->count()}} devis
                                    </th>
                                    <th></th>
                                </tr>
                                <tr class="bg-gray-100 text-gray-700">
                                    <th class="whitespace-nowrap">#</th>
                                    <th class="whitespace-nowrap">Commercial</th>
                                    <th class="whitespace-nowrap">Date du devis</th>
                                    <th class="whitespace-nowrap">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($devis as $devi)
                                    <tr>
                                        <td class="border-b dark:border-dark-5">
                                            <a href="{{route('devis.edit', [$client, $dossier, $devi])}}">#{{$devi->ref}}</a>
                                        </td>
                                        <td class="border-b dark:border-dark-5">
                                            {{$devi->commercial->format_name}}
                                        </td>
                                        <td class="border-b dark:border-dark-5">
                                            {{$devi->created_at->format('d/m/Y H:i')}}
                                        </td>
                                        <td class="border-b dark:border-dark-5">
                                            <div class="flex">
                                                @can('update', $devi)
                                                    <a class="flex items-center mr-3"
                                                       href="{{route('devis.edit', [$client, $dossier, $devi])}}">
                                                        @icon("edit", null,"w-4 h-4 mr-1")
                                                    </a>
                                                @endcan
                                                <x-corecrm::link-devis :devis="$devi" class="flex items-center mr-3">
                                                    @icon("show", null,"w-4 h-4 mr-1")
                                                </x-corecrm::link-devis>
                                                <a class='ignore-link' href="{{route('pdf-devis-download', $devi)}}">
                                                    @icon('pdf', null, 'w-4 h-4 mr-1')
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{$devis->links()}}
                        </div>
                    </x-basecore::resolve-type-view>
                </x-basecore::nav.tab>

                <x-basecore::resolve-type-view
                    :contrat-view-class="\Modules\CoreCRM\Contracts\Views\Dossiers\DossierTabViewContract::class"
                    :arguments="['client' => $client, 'dossier' => $dossier]"
                />
                @if(in_array('call', config('corecrm.features')))
                    <x-basecore::nav.tab name="call">
                        <livewire:callcrm::appel :dossier-id="$dossier->id" :client-id="$client->id"/>
                    </x-basecore::nav.tab>
                @endif
                @if(in_array('email', config('corecrm.features')))
                <x-basecore::nav.tab name="email">
                    email
                </x-basecore::nav.tab>
                @endif
                @if(in_array('document', config('corecrm.features')))
                <x-basecore::nav.tab name="documents">
                    <livewire:corecrm::document :dossier-id="$dossier->id" :client-id="$client->id"/>
                </x-basecore::nav.tab>
                @endif


            </x-basecore::partials.card>

            <livewire:corecrm::timeline :dossier="$dossier->id"/>

        </x-basecore::layout.panel-sidebar>
    </x-basecore::nav.layout>
</x-basecore::app-layout>
