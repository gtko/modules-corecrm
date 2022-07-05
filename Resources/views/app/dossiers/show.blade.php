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
                                <x-basecore::nav.menu-item name="call">
                                    <x-basecore::icon-label icon="bell" label="Rappels"/>
                                </x-basecore::nav.menu-item>
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
                    @if($client->email)
                    <x-basecore::resolve-type-view
                        :contrat-view-class="\Modules\CoreCRM\Contracts\Views\Devis\DevisListContrat::class"
                        :arguments="['client' => $client, 'dossier' => $dossier, 'devis' => $devis]"
                    >
                        Liste des devis
                    </x-basecore::resolve-type-view>
                    @else
                    <div class="p-4 bg-red-100 mt-4">
                        <h2 class="text-xl mb-3 text-red-900 flex justify-start items-center">
                            <svg class="h-8 w-8 mr-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M336 272C336 280.8 328.8 288 319.1 288C311.2 288 303.1 280.8 303.1 272V144C303.1 135.2 311.2 128 319.1 128C328.8 128 336 135.2 336 144V272zM295.1 352C295.1 338.7 306.7 328 319.1 328C333.3 328 344 338.7 344 352C344 365.3 333.3 376 319.1 376C306.7 376 295.1 365.3 295.1 352zM95.1 256C95.1 132.3 196.3 32 319.1 32C443.7 32 544 132.3 544 256C544 379.7 443.7 480 319.1 480C196.3 480 95.1 379.7 95.1 256zM319.1 448C426 448 512 362 512 256C512 149.1 426 64 319.1 64C213.1 64 127.1 149.1 127.1 256C127.1 362 213.1 448 319.1 448zM31.1 256C31.1 313.3 48.69 366.6 77.46 411.4C82.24 418.8 80.08 428.7 72.64 433.5C65.21 438.3 55.31 436.1 50.54 428.7C18.55 378.8 0 319.6 0 256C0 192.4 18.55 133.2 50.54 83.34C55.31 75.9 65.21 73.74 72.64 78.52C80.08 83.29 82.24 93.19 77.46 100.6C48.69 145.4 31.1 198.7 31.1 256zM640 256C640 319.6 621.4 378.8 589.5 428.7C584.7 436.1 574.8 438.3 567.4 433.5C559.9 428.7 557.8 418.8 562.5 411.4C591.3 366.6 608 313.3 608 256C608 198.7 591.3 145.4 562.5 100.6C557.8 93.19 559.9 83.29 567.4 78.52C574.8 73.74 584.7 75.9 589.5 83.34C621.4 133.2 640 192.4 640 256V256z"/></svg>
                            Impossible de créer un devis, si aucun email n'est fournit sur la fiche du client.
                        </h2>
                        <p class="text-normal text-gray-800">
                            L'email permet d'envoyer au client les différents documents liés à la création d'un devis. <br>
                            (devis, proforma, informations, cgv, cgu, facture, notification de paiement, ...)

                        </p>

                        <a class="mt-4 btn btn-danger" href="{{route('clients.edit', [$client])}}">
                            <svg class='h-4 w-4 mr-2' fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M386.7 22.63C411.7-2.365 452.3-2.365 477.3 22.63L489.4 34.74C514.4 59.74 514.4 100.3 489.4 125.3L269 345.6C260.6 354.1 249.9 359.1 238.2 362.7L147.6 383.6C142.2 384.8 136.6 383.2 132.7 379.3C128.8 375.4 127.2 369.8 128.4 364.4L149.3 273.8C152 262.1 157.9 251.4 166.4 242.1L386.7 22.63zM454.6 45.26C442.1 32.76 421.9 32.76 409.4 45.26L382.6 72L440 129.4L466.7 102.6C479.2 90.13 479.2 69.87 466.7 57.37L454.6 45.26zM180.5 281L165.3 346.7L230.1 331.5C236.8 330.2 242.2 327.2 246.4 322.1L417.4 152L360 94.63L189 265.6C184.8 269.8 181.8 275.2 180.5 281V281zM208 64C216.8 64 224 71.16 224 80C224 88.84 216.8 96 208 96H80C53.49 96 32 117.5 32 144V432C32 458.5 53.49 480 80 480H368C394.5 480 416 458.5 416 432V304C416 295.2 423.2 288 432 288C440.8 288 448 295.2 448 304V432C448 476.2 412.2 512 368 512H80C35.82 512 0 476.2 0 432V144C0 99.82 35.82 64 80 64H208z"/></svg>
                            Editer le client
                        </a>
                    </div>
                    @endif
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

            @if(in_array('task_dossier', config('corecrm.features')))
                <livewire:corecrm::dossier-tasks :dossier="$dossier"/>
            @endif

            @if(in_array('note_global', config('corecrm.features')))
                <livewire:corecrm::dossier-note-global :dossier="$dossier"/>
            @endif

            <livewire:corecrm::timeline :dossier="$dossier" :polling="true"/>

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
