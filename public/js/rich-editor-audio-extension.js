export default () => {
    const { Node } = window.FilamentRichEditor.tiptap.core

    return Node.create({
        name: 'audio',
        group: 'block',
        atom: true,
        draggable: true,
        dismissibleNodeView: true,

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
                const holder = document.createElement('div')
                holder.className = 'fi-fo-rich-editor-audio'
                holder.contentEditable = 'false'
                holder.setAttribute('data-tiptap-audio', '')

                const inner = document.createElement('div')
                inner.className = 'fi-fo-rich-editor-audio-inner'

                if (node.attrs.src) {
                    const player = document.createElement('audio')
                    player.setAttribute('controls', '')
                    player.setAttribute('preload', 'metadata')
                    player.src = node.attrs.src
                    inner.appendChild(player)
                } else {
                    const note = document.createElement('span')
                    note.className = 'fi-fo-rich-editor-audio-empty'
                    note.textContent = 'ملف صوتي'
                    inner.appendChild(note)
                }

                holder.appendChild(inner)

                return {
                    dom: holder,
                    ignoreMutation: () => true,
                    stopEvent: (event) => {
                        const target = event.target

                        return !(
                            target instanceof HTMLElement &&
                            target.closest('audio')
                        )
                    },
                    update(updatedNode) {
                        if (updatedNode.type.name !== 'audio') {
                            return false
                        }

                        const player = inner.querySelector('audio')

                        if (player && updatedNode.attrs.src) {
                            player.src = updatedNode.attrs.src
                        }

                        return true
                    },
                    selectNode() {
                        holder.classList.add('fi-fo-rich-editor-audio--selected')
                    },
                    deselectNode() {
                        holder.classList.remove('fi-fo-rich-editor-audio--selected')
                    },
                    destroy() {
                        holder.remove()
                    },
                }
            }
        },
    })
}