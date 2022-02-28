<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item :href="route('fournisseurs.index')">Fournisseurs</x-basecore::breadcrumb-item>
        <x-basecore::breadcrumb-item>{{$fournisseur->format_name}}</x-basecore::breadcrumb-item>
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
                <a href="{{ route('fournisseurs.index') }}" class="mr-4"
                ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
            </x-slot>
            <x-basecore::form
                method="PUT"
                action="{{ route('fournisseurs.update', $fournisseur) }}"
                class="mt-4"
            >
                <x-basecore::personne.form :personne="$fournisseur" :editing="true"/>


                <x-basecore::tom-select
                    name="tag_ids"
                    :collection="$tags"
                    label="name"
                    id="name"
                    :selected="$fournisseur->tagfournisseurs->pluck('name')->toArray()"
                    placeholder="Tags"
                    :create="true"
                    :livewire="false"
                />

                <div class="mt-10">
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

                    <button
                        type="submit"
                        class="button button-primary float-right"
                    >
                        <i class="mr-1 icon ion-md-save"></i>
                        @lang('basecore::crud.common.save')
                    </button>
                </div>
            </x-basecore::form>
        </x-basecore::partials.card>
    </x-basecore::layout.panel-left>
</x-basecore::app-layout>
