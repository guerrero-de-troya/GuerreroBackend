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
        if (! Schema::hasTable('departamentos')) {
            Schema::create('departamentos', function (Blueprint $table) {
                $table->id();
                $table->string('departamento')->unique();
                $table->foreignId('pais_id')->constrained('paises')->onDelete('restrict');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departamentos');
    }
};
