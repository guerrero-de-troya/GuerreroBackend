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
        $columnsToFix = [
            'tipo_documento_id',
            'genero_id',
            'nivel_id',
            'talla_id',
            'eps_id',
        ];

        foreach ($columnsToFix as $column) {
            if (Schema::hasColumn('personas', $column)) {
                $constraintName = "personas_{$column}_foreign";

                // Drop existing foreign key
                DB::statement("ALTER TABLE personas DROP CONSTRAINT IF EXISTS {$constraintName}");

                // Add new foreign key pointing to parametros
                Schema::table('personas', function (Blueprint $table) use ($column) {
                    $onDelete = in_array($column, ['talla_id']) ? 'set null' : 'restrict';
                    $table->foreign($column)->references('id')->on('parametros')->onDelete($onDelete);
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $columnsToFix = [
            'tipo_documento_id',
            'genero_id',
            'nivel_id',
            'talla_id',
            'eps_id',
        ];

        foreach ($columnsToFix as $column) {
            if (Schema::hasColumn('personas', $column)) {
                $constraintName = "personas_{$column}_foreign";

                // Drop foreign key pointing to parametros
                DB::statement("ALTER TABLE personas DROP CONSTRAINT IF EXISTS {$constraintName}");

                // Restore foreign key pointing to parametros_temas
                Schema::table('personas', function (Blueprint $table) use ($column) {
                    $onDelete = in_array($column, ['talla_id']) ? 'set null' : 'restrict';
                    $table->foreign($column)->references('id')->on('parametros_temas')->onDelete($onDelete);
                });
            }
        }
    }
};
