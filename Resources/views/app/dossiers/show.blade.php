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
        <livewire:corecrm::pipeline-steps :dossier="$dossier"/>
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
                                <a href="{{route('clients.edit', $client)}}" class="btn btn-primary py-1 px-2 w-full">Éditer
                                    le
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

                        @if(in_array('call', config('corecrm.features')))
                            @can('viewAny', \Modules\CallCRM\Models\Appel::class)
                                <x-basecore::nav.menu-item name="call">
                                    <x-basecore::icon-label icon="bell" label="Rappels"/>
                                </x-basecore::nav.menu-item>
                            @endcan
                        @endif

                    @can('viewAny', \Modules\CoreCRM\Contracts\Entities\DevisEntities::class)
                        <x-basecore::nav.menu-item name="devis">
                            <x-basecore::icon-label icon="devis" label="Devis" :size="20"/>
                        </x-basecore::nav.menu-item>
                    @endcan

                    <x-basecore::resolve-type-view
                        :contrat-view-class="\Modules\CoreCRM\Contracts\Views\Dossiers\DossierTabLabelViewContract::class"
                        :arguments="['client' => $client, 'dossier' => $dossier]"
                    />



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
                        Liste des devis
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
                @if(in_array('document', config('corecrm.features')))
                    <x-basecore::nav.tab name="documents">
                        <livewire:corecrm::document :dossier-id="$dossier->id" :client-id="$client->id"/>
                    </x-basecore::nav.tab>
                @endif


            </x-basecore::partials.card>

            @if(in_array('note_global', config('corecrm.features')))
                <livewire:corecrm::dossier-note-global :dossier="$dossier"/>
            @endif

            <livewire:corecrm::timeline :dossier="$dossier"/>

        </x-basecore::layout.panel-sidebar>
    </x-basecore::nav.layout>


    @push('modals')
        <livewire:basecore::modal
            size="2xl"
            name="send-mail"
            :type="Modules\BaseCore\Entities\TypeView::TYPE_LIVEWIRE"
            path='corecrm::middleware-work-flow-email'
        />
    @endpush

</x-basecore::app-layout>
