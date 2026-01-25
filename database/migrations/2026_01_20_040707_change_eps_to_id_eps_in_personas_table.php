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
            $table->foreignId('eps_id')->nullable()->after('ciudad_origen_id')->constrained('parametros_temas')->onDelete('restrict');
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
            $table->string('eps')->nullable()->after('ciudad_origen_id');
        });

        Schema::table('personas', function (Blueprint $table) {
            if (Schema::hasColumn('personas', 'eps_id')) {
                $table->dropForeign(['eps_id']);
                $table->dropColumn('eps_id');
            }
        });
    }
};
