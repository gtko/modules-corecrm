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
    if($this->data['actions'][$index]['class'] ?? false){
        $actionInstance = $instanceEvent->makeAction($this->data['actions'][$index]['class']);


        $variableData = [];
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

    <div class="flex mt-3 items-end justify-between" x-data="{
                            isActivate : [],
                            variables : null,
                            resolveFn : null,
                            replaceFn : null,
                            menuItemFn : null,
                            init(){

                                for(let elem of this.$root.querySelectorAll('input, textarea')){
                                    elem.addEventListener('focus', (e) => {
                                        this.focus(e)
                                    })
                                }

                                this.variables = {{json_encode($variableData ?? [])}}

        this.resolveFn = prefix => prefix === ''
            ? this.variables
            : this.variables.filter(variable => variable.label.startsWith(prefix))

        this.replaceFn = (variable, trigger) => `${trigger}${variable.value}} `

        this.menuItemFn = (variable, setItem, selected) => {
            const div = document.createElement('div')
            div.setAttribute('role', 'option')
            div.className = 'menu-item'
            if (selected) {
                div.classList.add('selected')
                div.setAttribute('aria-selected', '')
            }
            div.textContent = variable.label
            div.onclick = setItem

            return div
        }


    },
    focus(e){
        if(this.isActivate.indexOf(e.target) === -1){
            console.log('Start mentionnify');
            this.isActivate.push(e.target)
            new Mentionify(
                e.target,
                 document.getElementById('menu'),
                this.resolveFn,
                this.replaceFn,
                this.menuItemFn
            )
        }
    }
}">
        <div class="w-100 flex-grow-1 relative">
            @if($this->data['actions'][$index]['class'] ?? false)
                @php($actionInstance = $instanceEvent->makeAction($this->data['actions'][$index]['class']))
                @foreach($actionInstance->params()  as $paramskey =>  $params)
                    <x-corecrm::workflows.resolve-params :param="$params" :instance="$actionInstance" model="data.actions.{{$index}}.params.{{$paramskey}}"/>
                @endforeach
            @endif
        </div>
        <div wire:ignore id="menu" class="menu" role="listbox"></div>

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
