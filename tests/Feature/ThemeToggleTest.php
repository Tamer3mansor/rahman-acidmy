<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThemeToggleTest extends TestCase
{
    use RefreshDatabase;

    public function test_theme_is_bootstrapped_inline_before_the_stylesheet(): void
    {
        $this->seed(DatabaseSeeder::class);

        $content = $this->get('/')->assertOk()->getContent();

        $scriptPosition = strpos($content, "window.localStorage.getItem('theme')");
        $stylesheetPosition = strpos($content, 'build/assets/landing-');

        $this->assertIsInt($scriptPosition, 'The layout must read the stored theme.');
        $this->assertIsInt($stylesheetPosition, 'The landing stylesheet must be linked.');
        $this->assertLessThan(
            $stylesheetPosition,
            $scriptPosition,
            'The theme must be applied above the stylesheet, otherwise a dark-mode visitor sees a white flash.'
        );
    }

    public function test_bootstrap_falls_back_to_the_system_preference(): void
    {
        $this->seed(DatabaseSeeder::class);

        $content = $this->get('/')->assertOk()->getContent();

        $this->assertStringContainsString("matchMedia('(prefers-color-scheme: dark)')", $content);
        $this->assertStringContainsString("stored === 'light' || stored === 'dark'", $content);
        $this->assertStringContainsString("document.documentElement.setAttribute('data-theme', theme)", $content);
    }

    public function test_navigation_exposes_a_theme_toggle_in_both_contexts(): void
    {
        $this->seed(DatabaseSeeder::class);

        $content = $this->get('/')->assertOk()->getContent();

        $this->assertSame(2, substr_count($content, 'data-theme-toggle'));
        $this->assertStringContainsString('theme-toggle-mobile', $content);
        $this->assertStringContainsString('theme-icon-sun', $content);
        $this->assertStringContainsString('theme-icon-moon', $content);
        $this->assertStringContainsString('Changer de thème', $content);
    }

    public function test_built_landing_stylesheet_ships_the_dark_palette(): void
    {
        $stylesheet = $this->builtLandingStylesheet();

        if ($stylesheet === null) {
            $this->markTestSkipped('The landing stylesheet has not been built.');
        }

        $this->assertStringContainsString('html[data-theme=dark]', $stylesheet);
        $this->assertStringContainsString('--bg-page:#0e1311', $stylesheet);
        $this->assertStringContainsString('--text-strong:#f1f5f2', $stylesheet);
        $this->assertStringContainsString('html[data-theme=dark] .theme-icon-sun', $stylesheet);
    }

    public function test_theme_tokens_resolve_for_both_themes(): void
    {
        $stylesheet = $this->builtLandingStylesheet();

        if ($stylesheet === null) {
            $this->markTestSkipped('The landing stylesheet has not been built.');
        }

        // No rule may paint a themed surface with a raw brand colour; the only
        // allowed uses are the token definitions themselves.
        $normalized = preg_replace('/\s+/', '', $stylesheet) ?? $stylesheet;

        $this->assertStringNotContainsString('background:var(--cream)', $normalized);
        $this->assertStringNotContainsString('background:var(--white)', $normalized);
        $this->assertStringNotContainsString('background:var(--cream-dark)', $normalized);
    }

    private function builtLandingStylesheet(): ?string
    {
        $manifestPath = public_path('build/manifest.json');

        if (! is_file($manifestPath)) {
            return null;
        }

        $entry = json_decode((string) file_get_contents($manifestPath), true)['resources/css/landing.css'] ?? null;

        if (! is_array($entry) || ! isset($entry['file'])) {
            return null;
        }

        $file = public_path('build/'.$entry['file']);

        return is_file($file) ? (string) file_get_contents($file) : null;
    }
}
