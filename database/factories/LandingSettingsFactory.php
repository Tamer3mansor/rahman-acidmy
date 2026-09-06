<?php

namespace Database\Factories;

use App\Models\LandingSettings;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LandingSettings>
 */
class LandingSettingsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'hero_badge' => 'قيمة تجريبية',
            'hero_title' => 'عنوان تجريبي',
            'hero_title_accent' => 'مميز',
            'hero_subtitle' => 'وصف تجريبي',
            'hero_btn1_title' => 'زر أساسي',
            'hero_btn1_url' => '#trial-form',
            'hero_btn2_title' => 'زر ثانوي',
            'hero_btn2_url' => 'https://example.com',
            'hero_video_autoplay' => true,
            'hero_video_loop' => true,
        ];
    }
}
