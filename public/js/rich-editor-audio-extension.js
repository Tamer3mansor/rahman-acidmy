export default () => {
    const { Node } = window.FilamentRichEditor.tiptap.core

    return Node.create({
        name: 'audio',
        group: 'block',
        atom: true,
        draggable: true,

        addAttributes() {
            return {
                src: {},
                id: {
                    default: null,
                    parseHTML: (element) => element.getAttribute('data-id'),
                    renderHTML: (attributes) =>
                        attributes.id ? { 'data-id': attributes.id } : {},
                },
                controls: {
                    default: true,
                    parseHTML: (element) => element.hasAttribute('controls'),
                    renderHTML: (attributes) =>
                        attributes.controls ? { controls: '' } : {},
                },
            }
        },

        parseHTML() {
            return [{ tag: 'audio[src]' }, { tag: 'audio[data-id]' }]
        },

        renderHTML({ HTMLAttributes }) {
            return ['audio', { controls: '', preload: 'metadata', ...HTMLAttributes }]
        },

        addNodeView() {
            return ({ node }) => {
                const wrapper = document.createElement('div')
                wrapper.className = 'audio-node'
                wrapper.contentEditable = 'false'

                const player = document.createElement('audio')
                player.controls = true
                player.preload = 'metadata'
                player.className = 'audio-node__player'
                wrapper.appendChild(player)

                const meta = document.createElement('div')
                meta.className = 'audio-node__meta'

                const srcLine = document.createElement('span')
                srcLine.className = 'audio-node__src'
                meta.appendChild(srcLine)

                const openLink = document.createElement('a')
                openLink.className = 'audio-node__open'
                openLink.target = '_blank'
                openLink.rel = 'noopener'
                openLink.textContent = 'audio'
                meta.appendChild(openLink)

                wrapper.appendChild(meta)

                const setFrom = (currentNode) => {
                    const src = currentNode.attrs.src ?? ''
                    const hasSrc = src.length > 0

                    player.src = src

                    srcLine.textContent = hasSrc ? src : 'لا يوجد مصدر صوتي'
                    srcLine.classList.toggle('is-empty', !hasSrc)

                    if (hasSrc) {
                        openLink.href = src
                        openLink.removeAttribute('aria-disabled')
                    } else {
                        openLink.removeAttribute('href')
                        openLink.setAttribute('aria-disabled', 'true')
                    }
                }

                setFrom(node)

                return {
                    dom: wrapper,
                    ignoreMutation: () => true,
                    stopEvent: (event) => {
                        const target = event.target
                        return target instanceof HTMLElement && Boolean(target.closest('audio, a'))
                    },
                    update(updatedNode) {
                        if (updatedNode.type.name !== 'audio') {
                            return false
                        }

                        setFrom(updatedNode)

                        return true
                    },
                    selectNode: () => wrapper.classList.add('is-selected'),
                    deselectNode: () => wrapper.classList.remove('is-selected'),
                    destroy: () => wrapper.remove(),
                }
            }
        },
    })
}