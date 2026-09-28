<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Frees row-size room in the content settings tables before the course detail
 * page migrations add their columns.
 *
 * `course_page_settings` accumulated 65 `varchar(255)` columns across earlier
 * releases. Under utf8mb4 MySQL reserves 255 * 4 = 1,020 bytes for each one, so
 * those columns alone claim 66,300 bytes and exceed InnoDB's 65,535-byte row
 * limit. The table is therefore already over capacity, and
 * `ALTER TABLE ... ADD COLUMN` fails with "Row size too large" regardless of
 * the new column's type, `text` included. Widening only the new columns is not
 * enough; the legacy ones have to give their budget back.
 *
 * MySQL excludes BLOB and TEXT columns from that limit and stores them off-row
 * behind a pointer. Converting the legacy copy columns to `text` returns
 * roughly 62,000 bytes of headroom, which is what the per-audience copy, the
 * shared repeaters and the "why choose" cards need.
 *
 * Timestamp is deliberately ahead of the migrations it unblocks so it runs
 * first, and the body reads the live column list so it is idempotent and safe
 * on databases where an earlier run already converted some columns.
 *
 * Columns are left alone when they must stay narrow:
 *
 *   - Anything with a default value, because MySQL forbids DEFAULT on TEXT. The
 *     CTA and WhatsApp URL columns keep their `default('#')`.
 *   - Varchars shorter than 255, such as the `varchar(60)` meta title fields,
 *     which cost 240 bytes each and are not the problem.
 *
 * The conversion happens in a single ALTER so the table is rebuilt once rather
 * than once per column, and each column keeps its original charset, collation
 * and nullability. Values are never truncated, because TEXT is wider than the
 * varchar it replaces.
 */
return new class extends Migration
{
    /** @var array<int, string> */
    private const TABLES = [
        'course_page_settings',
        'landing_settings',
    ];

    public function up(): void
    {
        foreach (self::TABLES as $table) {
            $this->widenCopyColumns($table);
        }
    }

    /**
     * Reverting would recreate the exact 65,535-byte overflow this migration
     * exists to remove, so the change is intentionally one-way.
     */
    public function down(): void
    {
        //
    }

    private function widenCopyColumns(string $table): void
    {
        if (! Schema::hasTable($table)) {
            return;
        }

        $columns = DB::select(
            'SELECT COLUMN_NAME, IS_NULLABLE, CHARACTER_SET_NAME, COLLATION_NAME
               FROM information_schema.COLUMNS
              WHERE TABLE_SCHEMA = DATABASE()
                AND TABLE_NAME = ?
                AND DATA_TYPE = ?
                AND CHARACTER_MAXIMUM_LENGTH = 255
                AND COLUMN_DEFAULT IS NULL
              ORDER BY ORDINAL_POSITION',
            [$table, 'varchar'],
        );

        if ($columns === []) {
            return;
        }

        $definitions = [];

        foreach ($columns as $column) {
            $name = str_replace('`', '``', $column->COLUMN_NAME);
            $nullability = strtoupper($column->IS_NULLABLE) === 'YES' ? 'NULL' : 'NOT NULL';
            $charset = (string) $column->CHARACTER_SET_NAME;
            $collation = (string) $column->COLLATION_NAME;

            $definitions[] = $charset === ''
                ? sprintf('MODIFY COLUMN `%s` TEXT %s', $name, $nullability)
                : sprintf('MODIFY COLUMN `%s` TEXT CHARACTER SET `%s` COLLATE `%s` %s', $name, $charset, $collation, $nullability);
        }

        DB::statement(sprintf(
            'ALTER TABLE `%s` MODIFY %s',
            $table,
            implode(', ', $definitions),
        ));
    }
};
