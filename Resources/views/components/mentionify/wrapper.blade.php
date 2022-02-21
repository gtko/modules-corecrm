@props([
    'variableData' => [],
])

<div class='wrapper-mentionify' x-data="{
        isActivate: [],
        variables: null,
        resolveFn: null,
        replaceFn: null,
        menuItemFn: null,
        init() {

            window.addMentionify = (callback) => {
                callback(this);
            }

            for (let elem of this.$root.querySelectorAll('input, textarea')) {
                elem.addEventListener('focus', (e) => {
                console.log('Focus', e);
                    this.focus(e)
                })
            }

            this.variables = {{json_encode($variableData ?? [])}}

            this.resolveFn = prefix => prefix === ''
            ? this.variables
            : this.variables.filter(variable => {
                return variable.label.startsWith(prefix) || variable.label.indexOf(prefix) > -1
            })

        this.replaceFn = (variable, trigger) => `${trigger}${variable.value}} `

        this.menuItemFn = (variable, setItem, selected, query) => {
            const div = document.createElement('div')
            div.setAttribute('role', 'option')
            div.className = 'menu-item flex whitespace-normal whitespace-pre items-center block p-2 transition duration-300 ease-in-out hover:bg-gray-200 dark:hover:bg-dark-3'
            if (selected) {
                div.classList.add('selected')
                div.setAttribute('aria-selected', '')
                div.innerHTML = variable.label.replace(query, `<span class='font-bold text-blue-100'>${query}</span>`);
            } else {
                div.innerHTML = variable.label.replace(query, `<span class='font-bold text-green-600'>${query}</span>`);
            }

            div.onclick = setItem

            return div
        }


        },
        focus(e) {
            if (this.isActivate.indexOf(e.target) === -1) {
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
    {{ $slot }}

    <div wire:ignore id="menu" style="z-index:99999"
         class="menu shadow-lg rounded-md ring-1 ring-black ring-opacity-5 dropdown-menu__content box dark:bg-dark-6"
         role="listbox"></div>
</div>
