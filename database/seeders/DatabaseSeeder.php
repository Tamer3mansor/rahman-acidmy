<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );

        $this->call([
            LandingSettingsSeeder::class,
            HeroTrustPillsSeeder::class,
            JourneyStepsSeeder::class,
            CompareItemsSeeder::class,
            FormInfosSeeder::class,
            LandingTeachersSeeder::class,
            LandingFaqsSeeder::class,
            LandingTestimonialSeeder::class,
            BlogCategorySeeder::class,
            BlogPostSeeder::class,
            PricingPackageSeeder::class,
            PricingPerkSeeder::class,
        ]);
    }
}
