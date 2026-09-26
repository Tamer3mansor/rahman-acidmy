<?php

namespace Tests\Unit;

use App\Support\CourseContentResolver;
use PHPUnit\Framework\TestCase;

class CurriculumIconTest extends TestCase
{
    public function test_a_single_emoji_renders_in_the_badge(): void
    {
        $this->assertSame(
            ['kind' => 'emoji', 'value' => '📖'],
            CourseContentResolver::curriculumIcon('📖'),
        );
    }

    public function test_multi_codepoint_emoji_still_render_in_the_badge(): void
    {
        $this->assertSame(
            ['kind' => 'emoji', 'value' => '🇫🇷'],
            CourseContentResolver::curriculumIcon('🇫🇷'),
        );
    }

    public function test_a_word_is_rendered_as_a_label_instead_of_an_icon(): void
    {
        $this->assertSame(
            ['kind' => 'text', 'value' => 'Quran'],
            CourseContentResolver::curriculumIcon('Quran'),
        );

        $this->assertSame(
            ['kind' => 'text', 'value' => 'المصحف'],
            CourseContentResolver::curriculumIcon('المصحف'),
        );
    }

    public function test_a_font_awesome_class_is_rendered_as_an_icon(): void
    {
        $this->assertSame(
            ['kind' => 'fa', 'value' => 'fa-solid fa-book-open'],
            CourseContentResolver::curriculumIcon('fa-solid fa-book-open'),
        );
    }

    public function test_a_blank_icon_falls_back_to_the_default_icon(): void
    {
        $fallback = ['kind' => 'fallback', 'value' => 'fa-solid fa-book-open'];

        $this->assertSame($fallback, CourseContentResolver::curriculumIcon(null));
        $this->assertSame($fallback, CourseContentResolver::curriculumIcon(''));
        $this->assertSame($fallback, CourseContentResolver::curriculumIcon('   '));
    }
}
