<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item :href="route('pipelines.index')">Pipeline</x-basecore::breadcrumb-item>
        <x-basecore::breadcrumb-item>Ajouter une Pipeline</x-basecore::breadcrumb-item>
    </x-slot>

    <x-basecore::layout.panel-left>
        <x-basecore::partials.card>
            <x-slot name="title">
                <a href="{{ route('pipelines.index') }}" class="mr-4"
                ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
            </x-slot>

            <x-basecore::form
                method="POST"
                action="{{ route('pipelines.store') }}"
                class="mt-4"
            >
                <div class="flex flex-wrap">
                    <div class="w-full">
                        <div class="grid grid-cols-2">
                            <x-basecore::inputs.group>
                                <x-basecore::inputs.text
                                    name="name"
                                    label="Nom de la pipeline"
                                    value="{{ old('name') }}"
                                    maxlength="255"
                                    required="required"
                                />
                            </x-basecore::inputs.group>
                        </div>
                    </div>
                </div>

                <div class="mt-5 flex justify-between items-center">
                    <a href="{{ route('pipelines.index') }}" class="button">
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
