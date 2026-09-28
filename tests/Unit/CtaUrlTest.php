<?php

namespace Tests\Unit;

use App\Rules\CtaUrl;
use App\Support\CtaUrl as CtaUrlResolver;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class CtaUrlTest extends TestCase
{
    /**
     * @return array<string, array{string, bool}>
     */
    public static function validUrls(): array
    {
        return [
            'full https url' => ['https://wa.me/201028268553', true],
            'root relative path' => ['/blog', true],
            'root relative anchor' => ['/#trial-form', true],
            'bare anchor' => ['#trial-form', true],
            'lone hash' => ['#', true],
            'empty' => ['', true],
        ];
    }

    #[DataProvider('validUrls')]
    public function test_it_accepts_anchors_and_paths(string $url, bool $shouldPass): void
    {
        $validator = Validator::make(['cta_url' => $url], ['cta_url' => [new CtaUrl]]);

        $this->assertSame($shouldPass, $validator->passes(), $url.' failed validation.');
    }

    public function test_it_rejects_a_value_with_no_path_or_scheme(): void
    {
        $validator = Validator::make(['cta_url' => 'javascript:alert(1)'], ['cta_url' => [new CtaUrl]]);

        $this->assertFalse($validator->passes());
    }

    public function test_bare_anchor_is_left_alone_on_the_home_page(): void
    {
        $this->assertSame('#trial-form', CtaUrlResolver::resolve('#trial-form', 'home'));
    }

    public function test_bare_anchor_is_prefixed_with_the_home_route_on_inner_pages(): void
    {
        $this->assertSame(
            route('home').'#trial-form',
            CtaUrlResolver::resolve('#trial-form', 'kids'),
        );
    }

    public function test_external_and_root_relative_urls_are_never_rewritten(): void
    {
        $this->assertSame('https://wa.me/201028268553', CtaUrlResolver::resolve('https://wa.me/201028268553', 'kids'));
        $this->assertSame('/#trial-form', CtaUrlResolver::resolve('/#trial-form', 'kids'));
        $this->assertSame('/#trial-form', CtaUrlResolver::resolve('/#trial-form', 'home'));
    }
}
