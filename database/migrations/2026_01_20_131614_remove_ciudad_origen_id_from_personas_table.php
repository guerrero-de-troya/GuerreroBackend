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
        Schema::table('personas', function (Blueprint $table) {
            if (Schema::hasColumn('personas', 'ciudad_origen_id')) {
                $constraintName = 'personas_ciudad_origen_id_foreign';
                DB::statement("ALTER TABLE personas DROP CONSTRAINT IF EXISTS {$constraintName}");
                $table->dropColumn('ciudad_origen_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personas', function (Blueprint $table) {
            $table->foreignId('ciudad_origen_id')->nullable()->after('talla_id')->constrained('parametros_temas')->onDelete('restrict');
        });
    }
};
