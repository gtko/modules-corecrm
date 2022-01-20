<li class="grid grid-cols-3 items-center">
    <x-basecore::inputs.group key="condition_select">
        <x-basecore::inputs.select
            name="condition"
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

    <div key="condition_params" class="col-span-2 grid grid-cols-2 items-center">
    @if($this->data['conditions'][$index]['class'] ?? false)
        @php($instanceEvent = (new $this->data['events'][0]['class']))
        @php($instanceCondition = $instanceEvent->makeCondition($this->data['conditions'][$index]['class']))
        <x-basecore::inputs.group>
            <x-basecore::inputs.select
                name="comparateur"
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
            <x-corecrm::workflows.resolve-params :instance='$instanceCondition' :param="$instanceCondition->param()" model="data.conditions.{{$index}}.value"/>
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
    </div>

</li>
