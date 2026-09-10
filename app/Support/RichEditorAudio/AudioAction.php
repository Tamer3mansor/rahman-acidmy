<?php

namespace App\Support\RichEditorAudio;

use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\EditorCommand;
use Illuminate\Support\Str;
use Livewire\Component;

class AudioAction
{
    public static function make(): Action
    {
        return Action::make('attachAudio')
            ->label('إدراج ملف صوتي')
            ->modalHeading('إدراج ملف صوتي')
            ->modalSubmitActionLabel('إدراج')
            ->schema([
                FileUpload::make('file')
                    ->label('الملف الصوتي')
                    ->acceptedFileTypes(AudioPlugin::AUDIO_FILE_TYPES)
                    ->maxSize(AudioPlugin::MAX_FILE_SIZE_KB)
                    ->storeFiles(false)
                    ->required()
                    ->helperText('الحد الأقصى 50 ميجابايت. الصيغ المدعومة: MP3، WAV، OGG، M4A، AAC، WebM، FLAC.')
                    ->hiddenLabel(),
            ])
            ->action(function (array $arguments, array $data, RichEditor $component, Component $livewire): void {
                $id = null;
                $src = null;

                if ($data['file'] ?? null) {
                    $id = (string) Str::orderedUuid();

                    data_set($livewire, "componentFileAttachments.{$component->getStatePath()}.{$id}", $data['file']);
                    $src = $component->getUploadedFileAttachmentTemporaryUrl($data['file']);
                }

                if (blank($id) || blank($src)) {
                    return;
                }

                $component->runCommands(
                    [
                        EditorCommand::make('insertContent', arguments: [[
                            'type' => 'audio',
                            'attrs' => [
                                'id' => $id,
                                'src' => $src,
                            ],
                        ]]),
                    ],
                    editorSelection: $arguments['editorSelection'],
                );
            });
    }
}
