<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('personas', function (Blueprint $table) {
            $table->foreignId('departamento_id')->nullable()->after('pais_id')->constrained('departamentos')->onDelete('restrict');
            $table->foreignId('municipio_id')->nullable()->after('departamento_id')->constrained('municipios')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personas', function (Blueprint $table) {
            if (Schema::hasColumn('personas', 'departamento_id')) {
                $table->dropForeign(['departamento_id']);
            }
            if (Schema::hasColumn('personas', 'municipio_id')) {
                $table->dropForeign(['municipio_id']);
            }
            $table->dropColumn(['departamento_id', 'municipio_id']);
        });
    }
};
