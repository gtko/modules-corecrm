<li class="grid grid-cols-2" id="action_{{$index}}">
    <x-basecore::inputs.group>
        <x-basecore::inputs.select
            name="action"
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

    <?php
    $variableData = [];
    if($this->data['actions'][$index]['class'] ?? false){
        $actionInstance = $instanceEvent->makeAction($this->data['actions'][$index]['class']);

        if($actionInstance->isVariabled()){
            foreach($instanceEvent->variables() as $variable){
                foreach($variable->labels() as $label => $description){
                    $variableData[] = [
                        "value" => $variable->namespace().'.'.\Illuminate\Support\Str::slug($label),
                        "label" => $variable->namespace().'.'."$label - $description",
                    ];
                }
            }
        }
    }
    ?>

    <x-corecrm::mentionify.wrapper :variableData="$variableData">
        <div class="flex items-end justify-between">
            <div class="w-100 flex-grow-1 relative w-full">
                @if($this->data['actions'][$index]['class'] ?? false)
                    @php($actionInstance = $instanceEvent->makeAction($this->data['actions'][$index]['class']))
                    @foreach($actionInstance->params()  as $paramskey =>  $params)
                        <x-corecrm::workflows.resolve-params :param="$params" :instance="$actionInstance" model="data.actions.{{$index}}.params.{{$paramskey}}"/>
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
    </x-corecrm::mentionify.wrapper>

</li>
