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
            $table->dropForeign(['id_tipo_documento']);
            $table->dropForeign(['id_genero']);
            $table->dropForeign(['id_categoria']);
            $table->dropForeign(['id_talla']);
            $table->dropForeign(['id_ciudad_origen']);
            $table->dropForeign(['id_eps']);
        });

        Schema::table('personas', function (Blueprint $table) {
            $table->renameColumn('id_tipo_documento', 'tipo_documento_id');
            $table->renameColumn('id_genero', 'genero_id');
            $table->renameColumn('id_categoria', 'categoria_id');
            $table->renameColumn('id_talla', 'talla_id');
            $table->renameColumn('id_ciudad_origen', 'ciudad_origen_id');
            $table->renameColumn('id_eps', 'eps_id');
        });

        Schema::table('personas', function (Blueprint $table) {
            $table->foreign('tipo_documento_id')->references('id')->on('parametros_temas')->onDelete('restrict');
            $table->foreign('genero_id')->references('id')->on('parametros_temas')->onDelete('restrict');
            $table->foreign('categoria_id')->references('id')->on('parametros_temas')->onDelete('restrict');
            $table->foreign('talla_id')->references('id')->on('parametros_temas')->onDelete('set null');
            $table->foreign('ciudad_origen_id')->references('id')->on('parametros_temas')->onDelete('restrict');
            $table->foreign('eps_id')->references('id')->on('parametros_temas')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personas', function (Blueprint $table) {
            $table->dropForeign(['tipo_documento_id']);
            $table->dropForeign(['genero_id']);
            $table->dropForeign(['categoria_id']);
            $table->dropForeign(['talla_id']);
            $table->dropForeign(['ciudad_origen_id']);
            $table->dropForeign(['eps_id']);
        });

        Schema::table('personas', function (Blueprint $table) {
            $table->renameColumn('tipo_documento_id', 'id_tipo_documento');
            $table->renameColumn('genero_id', 'id_genero');
            $table->renameColumn('categoria_id', 'id_categoria');
            $table->renameColumn('talla_id', 'id_talla');
            $table->renameColumn('ciudad_origen_id', 'id_ciudad_origen');
            $table->renameColumn('eps_id', 'id_eps');
        });

        Schema::table('personas', function (Blueprint $table) {
            $table->foreign('id_tipo_documento')->references('id')->on('parametros_temas')->onDelete('restrict');
            $table->foreign('id_genero')->references('id')->on('parametros_temas')->onDelete('restrict');
            $table->foreign('id_categoria')->references('id')->on('parametros_temas')->onDelete('restrict');
            $table->foreign('id_talla')->references('id')->on('parametros_temas')->onDelete('set null');
            $table->foreign('id_ciudad_origen')->references('id')->on('parametros_temas')->onDelete('restrict');
            $table->foreign('id_eps')->references('id')->on('parametros_temas')->onDelete('restrict');
        });
    }
};
