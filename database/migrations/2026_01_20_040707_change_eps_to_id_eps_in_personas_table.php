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
            $table->foreignId('id_eps')->nullable()->after('id_ciudad_origen')->constrained('parametros_temas')->onDelete('restrict');
        });

        Schema::table('personas', function (Blueprint $table) {
            $table->dropColumn('eps');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personas', function (Blueprint $table) {
            $table->string('eps')->nullable()->after('id_ciudad_origen');
        });

        Schema::table('personas', function (Blueprint $table) {
            $table->dropForeign(['id_eps']);
            $table->dropColumn('id_eps');
        });
    }
};
