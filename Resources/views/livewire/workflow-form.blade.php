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
                        this.query = ''

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

                        this.query = textBeforeCaret.slice(triggerIdx + 1)
                        this.makeOptions(this.query)

                        const coords = getCaretCoordinates(this.ref, positionIndex)
                        const { top, left } = this.ref.getBoundingClientRect()

                        setTimeout(() => {
                            this.active = 0
                            this.left = coords.left + left + this.ref.scrollLeft
                            this.top = coords.top + top + coords.height - this.ref.scrollTop
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
                        this.menuRef.style.left = (this.left) + 'px'
                        this.menuRef.style.top = (this.top) + 'px'
                        this.menuRef.style.maxHeight = '150px';
                        this.menuRef.style.overflow = 'auto';
                        this.menuRef.innerHTML = ''

                        console.log();

                        this.options.forEach((option, idx) => {
                            this.menuRef.appendChild(this.menuItemFn(
                                option,
                                this.selectItem(idx),
                                this.active === idx,
                                this.query
                                ),
                            )
                        })
                    }
                }
            </script>
            <style>
                    .menu {
                        position: fixed;
                        z-index:9000;
                    }

                    .menu-item.selected {
                        background-color: #1d87cc;
                        color: white;
                    }

                </style>
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
