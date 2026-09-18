export default () => {
    const { Node } = window.FilamentRichEditor.tiptap.core

    return Node.create({
        name: 'audio',
        group: 'inline',
        inline: true,
        atom: true,
        draggable: true,

        addAttributes() {
            return {
                src: {
                    default: null,
                },
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
    })
}
