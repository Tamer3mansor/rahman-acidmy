<?php

namespace App\Support\RichEditorAudio;

use Filament\Forms\Components\RichEditor\Plugins\Contracts\HasToolbarButtons;
use Filament\Forms\Components\RichEditor\Plugins\Contracts\RichContentPlugin;
use Filament\Forms\Components\RichEditor\RichEditorTool;
use Filament\Support\Icons\Heroicon;
use Tiptap\Core\Extension;

class AudioPlugin implements HasToolbarButtons, RichContentPlugin
{
    public const MAX_FILE_SIZE_KB = 51200;

    public const AUDIO_FILE_TYPES = [
        'audio/mpeg',
        'audio/mp3',
        'audio/mpeg3',
        'audio/x-mpeg',
        'audio/x-mp3',
        'audio/wav',
        'audio/x-wav',
        'audio/wave',
        'audio/ogg',
        'audio/oga',
        'audio/mp4',
        'audio/x-m4a',
        'audio/m4a',
        'audio/aac',
        'audio/webm',
        'audio/flac',
        'audio/x-flac',
    ];

    public const ACCEPTED_FILE_TYPES = [
        'image/png',
        'image/jpeg',
        'image/gif',
        'image/webp',
        ...self::AUDIO_FILE_TYPES,
    ];

    /**
     * @return array<Extension>
     */
    public function getTipTapPhpExtensions(): array
    {
        return [
            new AudioExtension,
        ];
    }

    /**
     * @return array<string>
     */
    public function getTipTapJsExtensions(): array
    {
        return [
            '/js/rich-editor-audio-extension.js',
        ];
    }

    /**
     * @return array<RichEditorTool>
     */
    public function getEditorTools(): array
    {
        return [
            RichEditorTool::make('audio')
                ->label('إدراج ملف صوتي')
                ->icon(Heroicon::MusicalNote)
                ->iconAlias('forms:components.rich-editor.toolbar.audio')
                ->action('attachAudio')
                ->activeKey('audio'),
        ];
    }

    /**
     * @return array<Action>
     */
    public function getEditorActions(): array
    {
        return [
            AudioAction::make(),
        ];
    }

    /**
     * @return array<string | array<string | array<string>>>
     */
    public function getEnabledToolbarButtons(): array
    {
        return ['audio'];
    }

    /**
     * @return array<string>
     */
    public function getDisabledToolbarButtons(): array
    {
        return [];
    }
}
