<x-basecore::partials.card>
    <x-slot name="title">
        <a href="{{ route('pipelines.index') }}" class="mr-4"
        ><i class="mr-1 icon ion-md-arrow-back"></i
            ></a>
    </x-slot>

    <form wire:submit.prevent="store">
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


        <div class="my-5">
            <div class="flex justify-between items-center">
                <h2>Evenement</h2>

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
                                label="event"
                                wire:model="data.events.{{$index}}.class"
                                required="required"
                            >
                                <option>Sélectionner un événement</option>
                                @foreach($kernelEvents as $baseEvent)
                                    @php($instance = (new $baseEvent))
                                    <option value="{{$baseEvent}}">{{$instance->name()}}</option>
                                @endforeach
                            </x-basecore::inputs.select>
                        </x-basecore::inputs.group>
                    </li>
                @endforeach
            </ul>
        </div>

{{--        <div class="my-5">--}}
{{--            <div class="flex justify-between items-center">--}}
{{--                <h2>Conditions</h2>--}}

{{--                <x-basecore::loading-replace wire:target="addStatus">--}}
{{--                    <x-slot name="loader">--}}
{{--                        <button class="btn btn-primary" disabled>--}}
{{--                            @icon('spinner', 20, 'animate-spin mr-2') Ajouter une condition--}}
{{--                        </button>--}}
{{--                    </x-slot>--}}
{{--                    <button type='button' wire:click="addCondition" class="btn btn-primary">@icon('addCircle', 20, 'mr-2') Ajouter une condition</button>--}}
{{--                </x-basecore::loading-replace>--}}
{{--            </div>--}}

{{--            <ul role="list" class="divide-y divide-gray-200 my-2" wire:sortable="updateStatusOrder">--}}
{{--                @foreach($this->data['conditions'] as $index => $event)--}}
{{--                    <li class="grid grid-cols-3 items-center">--}}
{{--                        <x-basecore::inputs.group>--}}
{{--                            <x-basecore::inputs.text--}}
{{--                                name="name"--}}
{{--                                label="Champ"--}}
{{--                                wire:model="data.conditions.{{$index}}.field"--}}
{{--                                maxlength="255"--}}
{{--                                required="required"--}}
{{--                            />--}}
{{--                        </x-basecore::inputs.group>--}}
{{--                        <x-basecore::inputs.group>--}}
{{--                            <x-basecore::inputs.text--}}
{{--                                name="name"--}}
{{--                                label="condition"--}}
{{--                                wire:model="data.conditions.{{$index}}.condition"--}}
{{--                                maxlength="255"--}}
{{--                                required="required"--}}
{{--                            />--}}
{{--                        </x-basecore::inputs.group>--}}
{{--                        <x-basecore::inputs.group>--}}
{{--                            <x-basecore::inputs.text--}}
{{--                                name="name"--}}
{{--                                label="value"--}}
{{--                                wire:model="data.conditions.{{$index}}.value"--}}
{{--                                maxlength="255"--}}
{{--                                required="required"--}}
{{--                            />--}}
{{--                        </x-basecore::inputs.group>--}}
{{--                    </li>--}}
{{--                @endforeach--}}
{{--            </ul>--}}
{{--        </div>--}}

        <div class="my-5">
            <div class="flex justify-between items-center">
                <h2>Actions</h2>

                <x-basecore::loading-replace wire:target="addStatus">
                    <x-slot name="loader">
                        <button class="btn btn-primary" disabled>
                            @icon('spinner', 20, 'animate-spin mr-2') Ajouter une action
                        </button>
                    </x-slot>
                    <button type='button' wire:click="addAction" class="btn btn-primary">@icon('addCircle', 20, 'mr-2') Ajouter une action</button>
                </x-basecore::loading-replace>
            </div>

            <ul role="list" class="divide-y divide-gray-200 my-2" wire:sortable="updateStatusOrder">
                @foreach($this->data['actions'] as $index => $actions)
                    <li class="grid grid-cols-2">

                        <x-basecore::inputs.group>
                            <x-basecore::inputs.select
                                name="name"
                                label="event"
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

                        @if($this->data['actions'][$index]['class'] ?? false)

                            @foreach($instanceEvent->makeAction($this->data['actions'][$index]['class'])->params()  as $paramskey =>  $params)
                                @if($params instanceof Modules\CoreCRM\Flow\Works\Interfaces\TypeDataSelectGrouped)
                                    <x-basecore::inputs.group>
                                        <x-basecore::inputs.select
                                            name="name"
                                            label="{{$params->name()}}"
                                            wire:model="data.actions.{{$index}}.params.{{$paramskey}}"
                                            required="required"
                                        >
                                            <option>Sélectionner un {{$params->name()}}</option>
                                            @foreach($params->getOptions()  as $options)
                                                @if($params->isGrouped())
                                                    <optgroup label="{{$params->getFieldGroupeName($options)}}">
                                                    @foreach($params->getFieldGroupeValue($options) as $option)
                                                        <option value="{{$params->getFieldValue($option)}}">{{$params->getFieldLabel($option)}}</option>
                                                    @endforeach
                                                    </optgroup>
                                                @else
                                                    <option value="{{$params->getFieldValue($option)}}">{{$params->getFieldLabel($option)}}</option>
                                                @endif
                                            @endforeach
                                        </x-basecore::inputs.select>
                                    </x-basecore::inputs.group>
                                @elseif($params instanceof Modules\CoreCRM\Flow\Works\Interfaces\TypeDataSelect)
                                    <x-basecore::inputs.group>
                                        <x-basecore::inputs.select
                                            name="name"
                                            label="{{$params->name()}}"
                                            wire:model="data.actions.{{$index}}.params.{{$paramskey}}"
                                            required="required"
                                        >
                                            <option>Sélectionner un {{$params->name()}}</option>
                                            @foreach($params->getOptions() as $option)
                                                    <option value="{{$params->getFieldValue($option)}}">{{$params->getFieldLabel($option)}}</option>
                                            @endforeach
                                        </x-basecore::inputs.select>
                                    </x-basecore::inputs.group>
                                @endif
                            @endforeach
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>


        <div class="mt-5 flex justify-between items-center">
            <a href="{{ route('pipelines.index') }}" class="button">
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
    </form>

</x-basecore::partials.card>
