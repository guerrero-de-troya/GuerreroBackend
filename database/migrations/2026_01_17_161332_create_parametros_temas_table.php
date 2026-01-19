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
        Schema::create('parametros_temas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tema_id')->constrained('temas')->onDelete('cascade');
            $table->foreignId('parametro_id')->constrained('parametros')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['tema_id', 'parametro_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parametros_temas');
    }
};
