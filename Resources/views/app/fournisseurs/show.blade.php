<x-basecore::app-layout>

    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item :href="route('fournisseurs.index')">Fournisseurs</x-basecore::breadcrumb-item>
        <x-basecore::breadcrumb-item>{{$fournisseur->format_name}}</x-basecore::breadcrumb-item>
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.clients.show_title')
        </h2>
    </x-slot>
    <x-basecore::layout.panel-full>
        <x-basecore::personne.header :personne="$fournisseur">
            <x-slot name="title">Fournisseur détails</x-slot>
            <x-slot name="details">
                Créer le {{$fournisseur->created_at->diffForHumans()}}
            </x-slot>

            <x-slot name="stats">
                {{$stats ?? ''}}
            </x-slot>


        </x-basecore::personne.header>

        test content

    </x-basecore::layout.panel-full>
</x-basecore::app-layout>
