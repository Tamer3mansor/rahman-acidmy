<?php

use App\Enums\CourseAudience;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Wording the age template shipped with before the label was shortened to
     * "Dès N ans". Such a template wraps the label a second time and rendered
     * "Âge : À partir de À partir de 5 ans ans".
     */
    private const LEGACY_TEMPLATES = [
        'Âge : À partir de {age} ans',
        'Âge : À partir de {age}',
        'À partir de {age} ans',
        'À partir de {age}',
    ];

    public function up(): void
    {
        foreach (CourseAudience::cases() as $audience) {
            $column = $audience->value.'_card_age_template';

            DB::table('course_page_settings')
                ->whereIn($column, self::LEGACY_TEMPLATES)
                ->update([$column => 'Âge : {age}']);
        }
    }

    public function down(): void
    {
        // The shortened label is what the model renders, so the old wrapping
        // template cannot be restored without reintroducing the duplication.
    }
};
