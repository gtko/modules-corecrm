<form wire:submit.prevent="store">
    <x-basecore::partials.card>
    <x-slot name="title">
        <a href="{{ route('workflows.index') }}" class="mr-4"
        ><i class="mr-1 icon ion-md-arrow-back"></i
            ></a>
    </x-slot>
        <x-basecore::inputs.group>
            <x-basecore::inputs.text
                name="name"
                label="Nom"
                wire:model="data.name"
                maxlength="255"
                required="required"
            />
        </x-basecore::inputs.group>
        <x-basecore::inputs.group>
            <x-basecore::inputs.textarea
                name="description"
                label="Description"
                wire:model="data.description"
                maxlength="255"
            />
        </x-basecore::inputs.group>
    </x-basecore::partials.card>
    <x-basecore::partials.card class="mt-4">
        <x-slot name="title">
            Choisir un événement
        </x-slot>
        <div class="my-5">
            <div class="flex justify-between items-center">
{{--                <x-basecore::loading-replace wire:target="addStatus">--}}
{{--                    <x-slot name="loader">--}}
{{--                        <button class="btn btn-primary" disabled>--}}
{{--                            @icon('spinner', 20, 'animate-spin mr-2') Ajouter un evenements--}}
{{--                        </button>--}}
{{--                    </x-slot>--}}
{{--                    <button type='button' wire:click="addEvent" class="btn btn-primary">@icon('addCircle', 20, 'mr-2') Ajouter un evenements</button>--}}
{{--                </x-basecore::loading-replace>--}}
            </div>

            <ul role="list" class="divide-y divide-gray-200 my-2" wire:sortable="updateStatusOrder">
                @foreach($this->data['events'] as $index => $event)
                    <li>
                        <x-basecore::inputs.group>
                            <x-basecore::inputs.select
                                name="name"
                                label="Nom de l'événement"
                                wire:model="data.events.{{$index}}.class"
                                required="required"
                            >
                                <option>Sélectionner un événement</option>
                                @foreach($grouped as $groupe)
                                    <optgroup label="{{$groupe['name']}}">
                                    @foreach($groupe['events'] as $event)
                                        <option value="{{$event::class}}">{{$event->name()}}</option>
                                    @endforeach
                                    </optgroup>
                                @endforeach
                            </x-basecore::inputs.select>
                        </x-basecore::inputs.group>
                    </li>
                @endforeach
            </ul>
        </div>
    </x-basecore::partials.card>

    <livewire:corecrm::workflow-form-conditions :data="$data" />

    <x-corecrm::mentionify.assets />

    <x-basecore::partials.card class="mt-4">
        <x-slot name="title">
            Sélectionner une ou plusieurs actions
        </x-slot>
        <div class="my-5">
            <ul role="list" class="my-4">

            @forelse($this->data['actions'] ?? [] as $index => $actions)
                    <livewire:corecrm::workflow-form-action-item :data="$data" :index="$index" :key="'action_'.$index"/>
            @empty
                    <div>
                        <!-- This example requires Tailwind CSS v2.0+ -->
                        <span type="button" class="relative block w-full border-2 border-gray-300 border-dashed rounded-lg p-12 text-center">
                            @icon('lightningBolt', null, 'mx-auto h-12 w-12 text-gray-400')
                            <span class="mt-2 block text-sm font-medium text-gray-900 dark:text-white">
                             Aucune action ne s'applique au workflow.
                          </span>
                        </span>
                    </div>
            @endforelse
            </ul>
            <div class="flex justify-start items-center mx-2">
                <x-basecore::loading-replace wire:target="addStatus">
                    <x-slot name="loader">
                        <button class="btn btn-default" disabled>
                            @icon('spinner', 20, 'animate-spin mr-2') Ajouter une action
                        </button>
                    </x-slot>
                    <button type='button' wire:click="addAction" class="btn btn-default">@icon('addCircle', 20, 'mr-2') Ajouter une action</button>
                </x-basecore::loading-replace>
            </div>
        </div>

    </x-basecore::partials.card>

    <x-basecore::partials.card class="mt-4">

        <div class="mt-5 flex justify-between items-center">
            <a href="{{ route('workflows.index') }}" class="button">
                <i
                    class="mr-1 icon ion-md-return-left text-primary"
                ></i>
                @lang('basecore::crud.common.back')
            </a>

            <x-basecore::loading-replace wire:target="store">
                <x-slot name="loader">
                    <x-basecore::button>
                        @icon('spinner', 20, 'animate-spin mr-1')
                        @if($edition)
                            @lang('basecore::crud.common.update')
                        @else
                            @lang('basecore::crud.common.create')
                        @endif
                    </x-basecore::button>
                </x-slot>
                <x-basecore::button type="submit">
                    <i class="mr-1 icon ion-md-save"></i>
                    @if($edition)
                        @lang('basecore::crud.common.update')
                    @else
                        @lang('basecore::crud.common.create')
                    @endif
                </x-basecore::button>
            </x-basecore::loading-replace>

        </div>
    </x-basecore::partials.card>
</form>
