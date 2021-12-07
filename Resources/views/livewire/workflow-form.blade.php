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
            <script>
                const properties = [
                    'direction',
                    'boxSizing',
                    'width',
                    'height',
                    'overflowX',
                    'overflowY',

                    'borderTopWidth',
                    'borderRightWidth',
                    'borderBottomWidth',
                    'borderLeftWidth',
                    'borderStyle',

                    'paddingTop',
                    'paddingRight',
                    'paddingBottom',
                    'paddingLeft',

                    'fontStyle',
                    'fontVariant',
                    'fontWeight',
                    'fontStretch',
                    'fontSize',
                    'fontSizeAdjust',
                    'lineHeight',
                    'fontFamily',

                    'textAlign',
                    'textTransform',
                    'textIndent',
                    'textDecoration',

                    'letterSpacing',
                    'wordSpacing',

                    'tabSize',
                    'MozTabSize',
                ]
                const isFirefox = typeof window !== 'undefined' && window['mozInnerScreenX'] != null
                /**
                 * @param {HTMLTextAreaElement} element
                 * @param {number} position
                 */
                function getCaretCoordinates(element, position) {
                    const div = document.createElement('div')
                    document.body.appendChild(div)

                    const style = div.style
                    const computed = getComputedStyle(element)

                    style.whiteSpace = 'pre-wrap'
                    style.wordWrap = 'break-word'
                    style.position = 'absolute'
                    style.visibility = 'hidden'

                    properties.forEach(prop => {
                        style[prop] = computed[prop]
                    })

                    if (isFirefox) {
                        if (element.scrollHeight > parseInt(computed.height))
                            style.overflowY = 'scroll'
                    } else {
                        style.overflow = 'hidden'
                    }

                    div.textContent = element.value.substring(0, position)

                    const span = document.createElement('span')
                    span.textContent = element.value.substring(position) || '.'
                    div.appendChild(span)

                    const coordinates = {
                        top: span.offsetTop + parseInt(computed['borderTopWidth']),
                        left: span.offsetLeft + parseInt(computed['borderLeftWidth']),
                        // height: parseInt(computed['lineHeight'])
                        height: span.offsetHeight
                    }

                    div.remove()

                    return coordinates
                }
                class Mentionify {
                    constructor(ref, menuRef, resolveFn, replaceFn, menuItemFn) {
                        this.ref = ref
                        this.menuRef = menuRef
                        this.resolveFn = resolveFn
                        this.replaceFn = replaceFn
                        this.menuItemFn = menuItemFn
                        this.options = []

                        this.makeOptions = this.makeOptions.bind(this)
                        this.closeMenu = this.closeMenu.bind(this)
                        this.selectItem = this.selectItem.bind(this)
                        this.onInput = this.onInput.bind(this)
                        this.onKeyDown = this.onKeyDown.bind(this)
                        this.renderMenu = this.renderMenu.bind(this)

                        this.ref.addEventListener('input', this.onInput)
                        this.ref.addEventListener('keydown', this.onKeyDown)
                    }

                    async makeOptions(query) {
                        const options = await this.resolveFn(query)
                        if (options.lenght !== 0) {
                            this.options = options
                            this.renderMenu()
                        } else {
                            this.closeMenu()
                        }
                    }

                    closeMenu() {
                        setTimeout(() => {
                            this.options = []
                            this.left = undefined
                            this.top = undefined
                            this.triggerIdx = undefined
                            this.renderMenu()
                        }, 0)
                    }

                    selectItem(active) {
                        return () => {
                            const preMention = this.ref.value.substr(0, this.triggerIdx)
                            const option = this.options[active]
                            const mention = this.replaceFn(option, this.ref.value[this.triggerIdx])
                            const postMention = this.ref.value.substr(this.ref.selectionStart)
                            const newValue = `${preMention}${mention}${postMention}`
                            this.ref.value = newValue
                            const caretPosition = this.ref.value.length - postMention.length
                            this.ref.setSelectionRange(caretPosition, caretPosition)
                            this.closeMenu()
                            this.ref.focus()
                            this.ref.dispatchEvent(new Event('input'));
                            this.ref.dispatchEvent(new Event('change'));
                        }
                    }

                    onInput(ev) {
                        const positionIndex = this.ref.selectionStart
                        const textBeforeCaret = this.ref.value.slice(0, positionIndex)
                        const tokens = textBeforeCaret.split(/\s/)
                        const lastToken = tokens[tokens.length - 1]
                        const triggerIdx = textBeforeCaret.endsWith(lastToken)
                            ? textBeforeCaret.length - lastToken.length
                            : -1
                        const maybeTrigger = textBeforeCaret[triggerIdx]
                        const keystrokeTriggered = maybeTrigger === '{'

                        if (!keystrokeTriggered) {
                            this.closeMenu()
                            return
                        }

                        const query = textBeforeCaret.slice(triggerIdx + 1)
                        this.makeOptions(query)

                        const coords = getCaretCoordinates(this.ref, positionIndex)
                        const { top, left } = this.ref.getBoundingClientRect()

                        setTimeout(() => {
                            this.active = 0
                            this.left = window.scrollX  + coords.left + left + this.ref.scrollLeft - 300
                            this.top = window.scrollY +  coords.top + top + coords.height - this.ref.scrollTop - 80
                            this.triggerIdx = triggerIdx
                            this.renderMenu()
                        }, 100)
                    }

                    onKeyDown(ev) {
                        let keyCaught = false
                        if (this.triggerIdx !== undefined) {
                            switch (ev.key) {
                                case 'ArrowDown':
                                    this.active = Math.min(this.active + 1, this.options.length - 1)
                                    this.renderMenu()
                                    keyCaught = true
                                    break
                                case 'ArrowUp':
                                    this.active = Math.max(this.active - 1, 0)
                                    this.renderMenu()
                                    keyCaught = true
                                    break
                                case 'Enter':
                                case 'Tab':
                                    this.selectItem(this.active)()
                                    keyCaught = true
                                    break
                            }
                        }

                        if (keyCaught) {
                            ev.preventDefault()
                        }
                    }

                    renderMenu() {
                        // if (this.top === undefined) {
                        //     // this.menuRef.hidden = true
                        //     return
                        // }

                        this.menuRef.style.left = this.left + 'px'
                        this.menuRef.style.top = this.top + 'px'
                        this.menuRef.innerHTML = ''

                        this.options.forEach((option, idx) => {
                            this.menuRef.appendChild(this.menuItemFn(
                                option,
                                this.selectItem(idx),
                                this.active === idx))
                        })

                        console.log('Render menu ' + this.active);
                        // this.menuRef.hidden = false
                    }
                }
            </script>

                <style>
                    .menu {
                        background-color: #f3f3f3;
                        position: fixed;
                        z-index:9000;
                    }

                    .menu-item {
                        cursor: default;
                        padding: 1rem;
                    }

                    .menu-item.selected {
                        background-color: slateGray;
                        color: white;
                    }

                    .menu-item:hover:not(.selected) {
                        background-color: #fafafa;
                    }

                </style>

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

                        <?php
                            if($this->data['actions'][$index]['class'] ?? false){
                              $actionInstance = $instanceEvent->makeAction($this->data['actions'][$index]['class']);
                            }

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
                        ?>

                        <div class="flex items-end justify-between" x-data="{
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

                                this.variables = {{json_encode($variableData)}}

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
                            <div class="w-100 flex-grow-1 relative" wire:ignore>
                            @if($this->data['actions'][$index]['class'] ?? false)
                                @php($actionInstance = $instanceEvent->makeAction($this->data['actions'][$index]['class']))
                                @foreach($actionInstance->params()  as $paramskey =>  $params)
                                        <x-corecrm::workflows.resolve-params :param="$params" model="data.actions.{{$index}}.params.{{$paramskey}}"/>
                                        <div wire:ignore id="menu" class="menu" role="listbox"></div>
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
