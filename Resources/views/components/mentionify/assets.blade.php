<script>
    (function () {

// We'll copy the properties below into the mirror div.
// Note that some browsers, such as Firefox, do not concatenate properties
// into their shorthand (e.g. padding-top, padding-bottom etc. -> padding),
// so we have to list every single property explicitly.
        var properties = [
            'direction',  // RTL support
            'boxSizing',
            'width',  // on Chrome and IE, exclude the scrollbar, so the mirror div wraps exactly as the textarea does
            'height',
            'overflowX',
            'overflowY',  // copy the scrollbar for IE

            'borderTopWidth',
            'borderRightWidth',
            'borderBottomWidth',
            'borderLeftWidth',
            'borderStyle',

            'paddingTop',
            'paddingRight',
            'paddingBottom',
            'paddingLeft',

            // https://developer.mozilla.org/en-US/docs/Web/CSS/font
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
            'textDecoration',  // might not make a difference, but better be safe

            'letterSpacing',
            'wordSpacing',

            'tabSize',
            'MozTabSize'

        ];

        var isBrowser = (typeof window !== 'undefined');
        var isFirefox = (isBrowser && window.mozInnerScreenX != null);

        function getCaretCoordinates(element, position, options) {
            if (!isBrowser) {
                throw new Error('textarea-caret-position#getCaretCoordinates should only be called in a browser');
            }

            var debug = options && options.debug || false;
            if (debug) {
                var el = document.querySelector('#input-textarea-caret-position-mirror-div');
                if (el) el.parentNode.removeChild(el);
            }

            // The mirror div will replicate the textarea's style
            var div = document.createElement('div');
            div.id = 'input-textarea-caret-position-mirror-div';
            document.body.appendChild(div);

            var style = div.style;
            var computed = window.getComputedStyle ? window.getComputedStyle(element) : element.currentStyle;  // currentStyle for IE < 9
            var isInput = element.nodeName === 'INPUT';

            // Default textarea styles
            style.whiteSpace = 'pre-wrap';
            if (!isInput)
                style.wordWrap = 'break-word';  // only for textarea-s

            // Position off-screen
            style.position = 'absolute';  // required to return coordinates properly
            if (!debug)
                style.visibility = 'hidden';  // not 'display: none' because we want rendering

            // Transfer the element's properties to the div
            properties.forEach(function (prop) {
                if (isInput && prop === 'lineHeight') {
                    // Special case for <input>s because text is rendered centered and line height may be != height
                    if (computed.boxSizing === "border-box") {
                        var height = parseInt(computed.height);
                        var outerHeight =
                            parseInt(computed.paddingTop) +
                            parseInt(computed.paddingBottom) +
                            parseInt(computed.borderTopWidth) +
                            parseInt(computed.borderBottomWidth);
                        var targetHeight = outerHeight + parseInt(computed.lineHeight);
                        if (height > targetHeight) {
                            style.lineHeight = height - outerHeight + "px";
                        } else if (height === targetHeight) {
                            style.lineHeight = computed.lineHeight;
                        } else {
                            style.lineHeight = 0;
                        }
                    } else {
                        style.lineHeight = computed.height;
                    }
                } else {
                    style[prop] = computed[prop];
                }
            });

            if (isFirefox) {
                // Firefox lies about the overflow property for textareas: https://bugzilla.mozilla.org/show_bug.cgi?id=984275
                if (element.scrollHeight > parseInt(computed.height))
                    style.overflowY = 'scroll';
            } else {
                style.overflow = 'hidden';  // for Chrome to not render a scrollbar; IE keeps overflowY = 'scroll'
            }

            div.textContent = element.value.substring(0, position);
            // The second special handling for input type="text" vs textarea:
            // spaces need to be replaced with non-breaking spaces - http://stackoverflow.com/a/13402035/1269037
            if (isInput)
                div.textContent = div.textContent.replace(/\s/g, '\u00a0');

            var span = document.createElement('span');
            // Wrapping must be replicated *exactly*, including when a long word gets
            // onto the next line, with whitespace at the end of the line before (#7).
            // The  *only* reliable way to do that is to copy the *entire* rest of the
            // textarea's content into the <span> created at the caret position.
            // For inputs, just '.' would be enough, but no need to bother.
            span.textContent = element.value.substring(position) || '.';  // || because a completely empty faux span doesn't render at all
            div.appendChild(span);

            var coordinates = {
                top: span.offsetTop + parseInt(computed['borderTopWidth']),
                left: span.offsetLeft + parseInt(computed['borderLeftWidth']),
                height: parseInt(computed['lineHeight'])
            };

            if (debug) {
                span.style.backgroundColor = '#aaa';
            } else {
                document.body.removeChild(div);
            }

            return coordinates;
        }

        if (typeof module != 'undefined' && typeof module.exports != 'undefined') {
            module.exports = getCaretCoordinates;
        } else if(isBrowser) {
            window.getCaretCoordinates = getCaretCoordinates;
        }

        function getCaretIndex(element) {
            let position = 0;
            const isSupported = typeof window.getSelection !== "undefined";
            if (isSupported) {
                const selection = window.getSelection();
                if (selection.rangeCount !== 0) {
                    const range = window.getSelection().getRangeAt(0);
                    const preCaretRange = range.cloneRange();
                    preCaretRange.selectNodeContents(element);
                    preCaretRange.setEnd(range.endContainer, range.endOffset);
                    position = preCaretRange.toString().length;
                }
            }
            return position;
        }

        window.getCaretpos = getCaretIndex;

    }());

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
                this.ref.innerHtml = newValue
                const caretPosition = this.ref.value.length - postMention.length

                this.ref.setSelectionRange(caretPosition, caretPosition)

                this.closeMenu()
                this.ref.focus()
                this.ref.dispatchEvent(new Event('input'));
                this.ref.dispatchEvent(new Event('change'));
            }
        }

        onInput(ev) {

            console.log('WRAPPER CHANGE', this.ref.value);

            const positionIndex = this.ref.selectionStart
            const textBeforeCaret = this.ref.value.slice(0, positionIndex)
            console.log('PositionINDEX', positionIndex, textBeforeCaret);
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

            const coords = window.getCaretCoordinates(this.ref, positionIndex)
            const {top, left} = this.ref.getBoundingClientRect()

            setTimeout(() => {
                this.active = 0
                this.left = coords.left + left + this.ref.scrollLeft
                this.top = coords.top  + top + coords.height - this.ref.scrollTop
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

    window.Mentionify = Mentionify;
</script>
<style>
    .content .menu {
        position: fixed;
        z-index: 9000;
    }

    .content .menu-item.selected {
        background-color: #1d87cc;
        color: white;
    }
</style>
