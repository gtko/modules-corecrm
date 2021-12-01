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
    <x-basecore::partials.card class="mt-4">
        <x-slot name="title">
            Sélectionner une ou plusieurs conditions
        </x-slot>
        <div class="my-5">
            <ul role="list" class="divide-y divide-gray-200 my-2">
                @forelse($this->data['conditions'] as $index => $conditionArray)
                    <li class="grid grid-cols-3 items-center">
                        <x-basecore::inputs.group>
                            <x-basecore::inputs.select
                                name="name"
                                label="Condition"
                                wire:model="data.conditions.{{$index}}.class"
                                required="required"
                            >
                                <option>Sélectionner une condition</option>
                                @if($this->data['events'][0]['class'] ?? false)
                                    @php($instanceEvent = (new $this->data['events'][0]['class']))
                                    @foreach($instanceEvent->conditions()  as $condition)
                                        @php($instanceCondition = $instanceEvent->makeCondition($condition))
                                        <option value="{{$instanceCondition::class}}">{{$instanceCondition->name()}}</option>
                                    @endforeach
                                @endif
                            </x-basecore::inputs.select>
                        </x-basecore::inputs.group>

                        @if($this->data['conditions'][$index]['class'] ?? false)
                            @php($instanceEvent = (new $this->data['events'][0]['class']))
                            @php($instanceCondition = $instanceEvent->makeCondition($this->data['conditions'][$index]['class']))
                            <x-basecore::inputs.group>
                                <x-basecore::inputs.select
                                    name="name"
                                    label="Comparateur"
                                    wire:model="data.conditions.{{$index}}.condition"
                                    required="required"
                                >
                                    <option>Sélectionner une action</option>
                                        @foreach($instanceCondition->conditions()  as $signe => $label)
                                            <option value="{{$signe}}">{{$label}}</option>
                                        @endforeach
                                </x-basecore::inputs.select>
                            </x-basecore::inputs.group>
                            <div class="flex items-end justify-between">
                                <x-corecrm::workflows.resolve-params :param="$instanceCondition->param()" model="data.conditions.{{$index}}.value"/>
                                <x-basecore::loading-replace wire:target="deleteCondition({{$index}})">
                                    <x-slot name="loader">
                                        @icon('spinner',null, 'animate-spin ml-1 mb-3')
                                    </x-slot>
                                    <div wire:click="deleteCondition({{$index}})" class="hover:text-red-600 cursor-pointer">
                                        @icon('delete', null, 'ml-1 mb-3')
                                    </div>
                                </x-basecore::loading-replace>
                            </div>
                        @else
                            <span></span>
                            <div class="flex h-100 min-h-full items-end justify-end">
                                <x-basecore::loading-replace wire:target="deleteCondition({{$index}})">
                                    <x-slot name="loader">
                                        @icon('spinner',null, 'animate-spin ml-1 mb-3')
                                    </x-slot>
                                    <div wire:click="deleteCondition({{$index}})" class="hover:text-red-600 cursor-pointer">
                                        @icon('delete', null, 'ml-1 mb-3')
                                    </div>
                                </x-basecore::loading-replace>
                            </div>
                        @endif


                    </li>
                @empty
                    <div>
                        <!-- This example requires Tailwind CSS v2.0+ -->
                        <span type="button" class="relative block w-full border-2 border-gray-300 border-dashed rounded-lg p-12 text-center">
                            @icon('task', null, 'mx-auto h-12 w-12 text-gray-400')
                            <span class="mt-2 block text-sm font-medium text-gray-900 dark:text-white">
                             Aucune condition ne s'applique au workflow.
                          </span>
                        </span>
                    </div>
                @endforelse
            </ul>
            <div class="flex justify-start items-center mx-2">
                <x-basecore::loading-replace wire:target="addStatus">
                    <x-slot name="loader">
                        <button class="btn btn-default" disabled>
                            @icon('spinner', 20, 'animate-spin mr-2') Ajouter une condition
                        </button>
                    </x-slot>
                    <button type='button' wire:click="addCondition" class="btn btn-default">@icon('addCircle', 20, 'mr-2') Ajouter une condition</button>
                </x-basecore::loading-replace>
            </div>
        </div>
    </x-basecore::partials.card>
    <x-basecore::partials.card class="mt-4">
        <x-slot name="title">
            Sélectionner une ou plusieurs actions
        </x-slot>
        <div class="my-5">
            <ul role="list" class="my-4">
                @forelse($this->data['actions'] ?? [] as $index => $actions)
                    <li class="grid grid-cols-2" id="action_{{$index}}">
                        <x-basecore::inputs.group>
                            <x-basecore::inputs.select
                                name="name"
                                label="Action"
                                wire:model="data.actions.{{$index}}.class"
                                required="required"
                            >
                                <option>Sélectionner une action</option>
                                @if($this->data['events'][0]['class'] ?? false)
                                    @php($instanceEvent = (new $this->data['events'][0]['class']))
                                    @foreach($instanceEvent->actions()  as $action)
                                        @php($instanceAction = $instanceEvent->makeAction($action))
                                        <option value="{{$instanceAction::class}}">{{$instanceAction->name()}}</option>
                                    @endforeach
                                @endif
                            </x-basecore::inputs.select>
                        </x-basecore::inputs.group>

                        <div class="flex items-end justify-between">
                            <div class="w-100 flex-grow-1">
                        @if($this->data['actions'][$index]['class'] ?? false)
                            @foreach($instanceEvent->makeAction($this->data['actions'][$index]['class'])->params()  as $paramskey =>  $params)
                                 <x-corecrm::workflows.resolve-params :param="$params" model="data.actions.{{$index}}.params.{{$paramskey}}"/>
                            @endforeach
                        @endif
                            </div>
                            <x-basecore::loading-replace wire:target="deleteAction({{$index}})">
                                <x-slot name="loader">
                                    @icon('spinner',null, 'animate-spin ml-1 mb-3')
                                </x-slot>
                                <div wire:click="deleteAction({{$index}})" class="hover:text-red-600 cursor-pointer">
                                    @icon('delete', null, 'ml-1 mb-3')
                                </div>
                            </x-basecore::loading-replace>
                        </div>

                    </li>
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
