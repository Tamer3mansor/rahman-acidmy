<?php

namespace App\Filament\Schemas\Components;

use Filament\Forms\Components\RichEditor;

class AudioRichEditor extends RichEditor
{
    /**
     * Resolves file attachment ids for both image and audio nodes so that
     * inline audio files uploaded via the rich editor are persisted to
     * permanent storage when the form is submitted.
     *
     * @return array<string>
     */
    public function resolveFileAttachmentIds(): array
    {
        $fileAttachmentIds = [];

        $this->rawState(
            $this->getTipTapEditor()
                ->setContent($this->getRawState() ?? [
                    'type' => 'doc',
                    'content' => [],
                ])
                ->descendants(function (object &$node) use (&$fileAttachmentIds): void {
                    if (! in_array($node->type, ['image', 'audio'], strict: true)) {
                        return;
                    }

                    if (blank($node->attrs->id ?? null)) {
                        return;
                    }

                    $attachment = $this->getUploadedFileAttachment($node->attrs->id);

                    if ($attachment) {
                        $node->attrs->id = $this->saveUploadedFileAttachment($attachment);
                        $node->attrs->src = $this->getFileAttachmentUrl($node->attrs->id);

                        $fileAttachmentIds[] = $node->attrs->id;

                        return;
                    }

                    if (filled($this->getFileAttachmentUrl($node->attrs->id))) {
                        $fileAttachmentIds[] = $node->attrs->id;

                        return;
                    }

                    $fileAttachmentIdFromAnotherRecord = $this->saveFileAttachmentFromAnotherRecord($node->attrs->id);

                    if (blank($fileAttachmentIdFromAnotherRecord)) {
                        $fileAttachmentIds[] = $node->attrs->id;

                        return;
                    }

                    $node->attrs->id = $fileAttachmentIdFromAnotherRecord;
                    $node->attrs->src = $this->getFileAttachmentUrl($fileAttachmentIdFromAnotherRecord) ?? $node->attrs->src ?? null;
                })
                ->getDocument(),
        );

        return $fileAttachmentIds;
    }
}
