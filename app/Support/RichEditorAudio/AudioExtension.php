<?php

namespace App\Support\RichEditorAudio;

use DOMElement;
use Tiptap\Core\Node;
use Tiptap\Utils\HTML;

class AudioExtension extends Node
{
    public static $name = 'audio';

    public function addOptions()
    {
        return [
            'HTMLAttributes' => [],
        ];
    }

    public function parseHTML()
    {
        return [
            [
                'tag' => 'audio[src]',
            ],
            [
                'tag' => 'audio[data-id]',
            ],
        ];
    }

    public function addAttributes()
    {
        return [
            'src' => [],
            'id' => [
                'parseHTML' => fn (DOMElement $DOMNode) => $DOMNode->getAttribute('data-id') ?: null,
                'renderHTML' => fn ($attributes) => ['data-id' => $attributes->id ?? null],
            ],
            'controls' => [
                'parseHTML' => fn (DOMElement $DOMNode) => $DOMNode->hasAttribute('controls'),
                'renderHTML' => fn ($attributes) => (($attributes->controls ?? true) ? ['controls' => 'controls'] : null),
            ],
        ];
    }

    public function renderHTML($node, $HTMLAttributes = [])
    {
        return [
            'audio',
            HTML::mergeAttributes(
                $this->options['HTMLAttributes'],
                ['controls' => 'controls', 'preload' => 'metadata'],
                $HTMLAttributes,
            ),
        ];
    }
}
