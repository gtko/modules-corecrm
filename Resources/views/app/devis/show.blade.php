<x-basecore::app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.devis.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-basecore::partials.card>
                <x-slot name="title">
                    <a href="{{ route('devis.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <div class="mt-4 px-4">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.devis.inputs.dossier_id')
                        </h5>
                        <span
                            >{{ optional($devi->dossier)->date_start ?? '-'
                            }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.devis.inputs.commercial_id')
                        </h5>
                        <span
                            >{{ optional($devi->commercial)->password ?? '-'
                            }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.devis.inputs.data')
                        </h5>
                        <pre>{{ json_encode($devi->data) ?? '-' }}</pre>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.devis.inputs.tva_applicable')
                        </h5>
                        <span>{{ $devi->tva_applicable ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.devis.inputs.fournisseur_id')
                        </h5>
                        <span
                            >{{ optional($devi->fournisseur)->password ?? '-'
                            }}</span
                        >
                    </div>
                </div>
                <div class="mt-10">
                    <a href="{{ route('devis.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('basecore::crud.common.back')
                    </a>

                    @can('create', Modules\CoreCRM\Contracts\Entities\DevisEntities::class)
                    <a href="{{ route('devis.create') }}" class="button">
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('basecore::crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-basecore::partials.card>
        </div>
    </div>
</x-basecore::app-layout>
