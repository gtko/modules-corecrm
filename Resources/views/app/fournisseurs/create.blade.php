<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item :href="route('fournisseurs.index')">Fournisseurs</x-basecore::breadcrumb-item>
        <x-basecore::breadcrumb-item>Ajouter un fournisseur</x-basecore::breadcrumb-item>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.clients.create_title')
        </h2>
    </x-slot>

    <x-basecore::layout.panel-left>
            <x-basecore::partials.card>
                <x-slot name="title">
                    <a href="{{ route('fournisseurs.index') }}" class="mr-4"
                    ><i class="mr-1 icon ion-md-arrow-back"></i
                        ></a>
                </x-slot>

                <x-basecore::form
                    method="POST"
                    action="{{ route('fournisseurs.store') }}"
                    class="mt-4"
                >
                    <x-basecore::personne.form />

                    <x-basecore::inputs.group>
                        <label>Catégories du fournisseur</label>
                        <x-basecore::tom-select
                            name="tag_ids"
                            :collection="$tags"
                            label="name"
                            id="name"
                            placeholder="Tags"
                            :create="true"
                            :livewire="false"
                        />
                    </x-basecore::inputs.group>

                    <div class="mt-5 flex justify-between items-center">
                        <a href="{{ route('fournisseurs.index') }}" class="button">
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

                        <x-basecore::button type="submit">
                            <i class="mr-1 icon ion-md-save"></i>
                            @lang('basecore::crud.common.save')
                        </x-basecore::button>
                    </div>
                </x-basecore::form>
            </x-basecore::partials.card>
    </x-basecore::layout.panel-left>
</x-basecore::app-layout>
