<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item :href="route('statuses.index')">Statuts</x-basecore::breadcrumb-item>
        <x-basecore::breadcrumb-item :href="route('statuses.show', $status)">{{$status->label}}</x-basecore::breadcrumb-item>
        <x-basecore::breadcrumb-item>Edit</x-basecore::breadcrumb-item>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.statuses.edit_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-basecore::partials.card>
                <x-slot name="title">
                    <a href="{{ route('statuses.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <x-basecore::form
                    method="PUT"
                    action="{{ route('statuses.update', $status) }}"
                    class="mt-4"
                >
                    @include('corecrm::app.statuses.form-inputs')

                    <div class="mt-10">
                        <a href="{{ route('statuses.index') }}" class="button">
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

                        <a href="{{ route('statuses.create') }}" class="button">
                            <i class="mr-1 icon ion-md-add text-primary"></i>
                            @lang('basecore::crud.common.create')
                        </a>

                        <button
                            type="submit"
                            class="button button-primary float-right"
                        >
                            <i class="mr-1 icon ion-md-save"></i>
                            @lang('basecore::crud.common.update')
                        </button>
                    </div>
                </x-basecore::form>
            </x-basecore::partials.card>
        </div>
    </div>
</x-basecore::app-layout>
