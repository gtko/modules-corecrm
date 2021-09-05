<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item :href="route('sources.index')">Source</x-basecore::breadcrumb-item>
        <x-basecore::breadcrumb-item :href="route('sources.show', $source)">{{$source->label}}</x-basecore::breadcrumb-item>
        <x-basecore::breadcrumb-item>Edit</x-basecore::breadcrumb-item>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.sources.edit_title')
        </h2>
    </x-slot>

    <x-basecore::layout.panel-left>
            <x-basecore::partials.card>
                <x-slot name="title">
                    <a href="{{ route('sources.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <x-basecore::form
                    method="PUT"
                    action="{{ route('sources.update', $source) }}"
                    class="mt-4"
                >
                    @include('corecrm::app.sources.form-inputs')

                    <div class="mt-10">
                        <a href="{{ route('sources.index') }}" class="button">
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

                        <a href="{{ route('sources.create') }}" class="button">
                            <i class="mr-1 icon ion-md-add text-primary"></i>
                            @lang('basecore::crud.common.create')
                        </a>

                        <x-basecore::button type="submit">
                            <i class="mr-1 icon ion-md-save"></i>
                            @lang('basecore::crud.common.update')
                        </x-basecore::button>
                    </div>
                </x-basecore::form>
            </x-basecore::partials.card>
    </x-basecore::layout.panel-left>
</x-basecore::app-layout>
