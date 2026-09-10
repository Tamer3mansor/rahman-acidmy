<?php

namespace Tests\Feature;

use App\Support\RichEditorAudio\AudioExtension;
use App\Support\RichEditorAudio\AudioPlugin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tiptap\Editor;
use Tiptap\Extensions\StarterKit;

class RichEditorAudioTest extends TestCase
{
    use RefreshDatabase;

    public function test_audio_extension_parses_audio_html_into_a_document_node(): void
    {
        $editor = new Editor([
            'extensions' => [
                new StarterKit,
                new AudioExtension,
            ],
        ]);

        $document = json_decode($editor->setContent('<p>نص قبل</p><audio controls src="/storage/lessons/attachments/audio.mp3" data-id="abc-123"></audio><p>نص بعد</p>')->getJSON(), true);

        $audioNode = $document['content'][1];

        $this->assertSame('audio', $audioNode['type']);
        $this->assertSame('/storage/lessons/attachments/audio.mp3', $audioNode['attrs']['src']);
        $this->assertSame('abc-123', $audioNode['attrs']['id']);
        $this->assertTrue($audioNode['attrs']['controls']);
    }

    public function test_audio_extension_renders_audio_node_back_to_html(): void
    {
        $editor = new Editor([
            'extensions' => [
                new StarterKit,
                new AudioExtension,
            ],
        ]);

        $document = json_decode($editor->setContent('<audio controls src="/storage/lessons/attachments/audio.mp3" data-id="abc-123"></audio>')->getJSON(), true);

        $html = $editor->setContent($document)->getHTML();

        $this->assertStringContainsString('<audio', $html);
        $this->assertStringContainsString('controls="controls"', $html);
        $this->assertStringContainsString('data-id="abc-123"', $html);
        $this->assertStringContainsString('src="/storage/lessons/attachments/audio.mp3"', $html);
    }

    public function test_audio_plugin_registers_tool_and_extensions(): void
    {
        $plugin = new AudioPlugin;

        $this->assertSame(['audio'], $plugin->getEnabledToolbarButtons());
        $this->assertNotEmpty($plugin->getTipTapPhpExtensions());
        $this->assertNotEmpty($plugin->getTipTapJsExtensions());
        $this->assertNotEmpty($plugin->getEditorTools());
        $this->assertNotEmpty($plugin->getEditorActions());
        $this->assertContains('audio/mpeg', AudioPlugin::AUDIO_FILE_TYPES);
        $this->assertContains('image/jpeg', AudioPlugin::ACCEPTED_FILE_TYPES);
    }
}
