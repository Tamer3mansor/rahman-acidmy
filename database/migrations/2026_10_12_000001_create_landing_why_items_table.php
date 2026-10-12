<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('landing_why_items')) {
            return;
        }

        Schema::create('landing_why_items', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        $this->seedDefaultItems();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_why_items');
    }

    /**
     * Starter copy so the section is previewable right after migrating.
     * The LandingWhyItemsSeeder mirrors these rows (updateOrCreate by title).
     */
    private function seedDefaultItems(): void
    {
        $now = now();

        $items = [
            ['icon' => '🕌', 'title' => 'Enseignants diplômés de l\'Al-Azhar', 'description' => 'Tous nos enseignants sont diplômés de l\'Al-Azhar et titulaires d\'Ijazah certifiées en Tajwid, avec une expérience confirmée auprès des enfants et des adultes.'],
            ['icon' => '👨‍👩‍👧', 'title' => '100% particuliers', 'description' => 'Chaque élève travaille seul avec son enseignant, sans groupe ni distraction, et le rythme s\'ajuste à son niveau réel.'],
            ['icon' => '📊', 'title' => 'Suivi détaillé pour les parents', 'description' => 'Un rapport après chaque séance avec les acquis, les points forts et les points à retravailler.'],
            ['icon' => '⏰', 'title' => 'Horaires flexibles 7j/7', 'description' => 'De 7h à 22h, avec la possibilité de déplacer ou d\'annuler un créneau gratuitement à tout moment.'],
            ['icon' => '📈', 'title' => 'Progression mesurable', 'description' => 'Une évaluation régulière des acquis et des objectifs clairs à chaque étape du parcours.'],
            ['icon' => '🎁', 'title' => 'Première séance offerte', 'description' => 'La première séance est gratuite et sans engagement, pour évaluer la méthode et l\'enseignant en toute tranquillité.'],
        ];

        $rows = [];

        foreach ($items as $sort => $item) {
            $rows[] = [
                'icon' => $item['icon'],
                'title' => $item['title'],
                'description' => $item['description'],
                'is_active' => true,
                'sort_order' => $sort,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('landing_why_items')->insert($rows);
    }
};
