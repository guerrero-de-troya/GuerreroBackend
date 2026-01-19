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
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('primer_nombre');
            $table->string('segundo_nombre')->nullable();
            $table->string('primer_apellido');
            $table->string('segundo_apellido')->nullable();
            $table->foreignId('id_tipo_documento')->constrained('parametros_temas')->onDelete('restrict');
            $table->string('numero_documento')->unique();
            $table->string('telefono')->unique();
            $table->integer('edad');
            $table->foreignId('id_genero')->constrained('parametros_temas')->onDelete('restrict');
            $table->foreignId('id_categoria')->constrained('parametros_temas')->onDelete('restrict');
            $table->string('camisa')->nullable();
            $table->foreignId('id_talla')->nullable()->constrained('parametros_temas')->onDelete('set null');
            $table->foreignId('id_ciudad_origen')->constrained('parametros_temas')->onDelete('restrict');
            $table->string('eps');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
