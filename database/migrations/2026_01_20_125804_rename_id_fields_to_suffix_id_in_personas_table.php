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
        $columnsToRename = [
            'id_tipo_documento' => 'tipo_documento_id',
            'id_genero' => 'genero_id',
            'id_categoria' => 'categoria_id',
            'id_talla' => 'talla_id',
            'id_ciudad_origen' => 'ciudad_origen_id',
            'id_eps' => 'eps_id',
        ];

        foreach ($columnsToRename as $oldName => $newName) {
            if (Schema::hasColumn('personas', $oldName)) {
                $constraintName = "personas_{$oldName}_foreign";
                DB::statement("ALTER TABLE personas DROP CONSTRAINT IF EXISTS {$constraintName}");
            }
        }

        Schema::table('personas', function (Blueprint $table) use ($columnsToRename) {
            foreach ($columnsToRename as $oldName => $newName) {
                if (Schema::hasColumn('personas', $oldName)) {
                    $table->renameColumn($oldName, $newName);
                }
            }
        });

        $foreignKeys = [
            'tipo_documento_id' => 'restrict',
            'genero_id' => 'restrict',
            'categoria_id' => 'restrict',
            'talla_id' => 'set null',
            'ciudad_origen_id' => 'restrict',
            'eps_id' => 'restrict',
        ];

        foreach ($foreignKeys as $column => $onDelete) {
            if (Schema::hasColumn('personas', $column)) {
                $constraintName = "personas_{$column}_foreign";
                $constraintExists = DB::selectOne(
                    'SELECT 1 FROM pg_constraint WHERE conname = ?',
                    [$constraintName]
                );

                if (! $constraintExists) {
                    Schema::table('personas', function (Blueprint $table) use ($column, $onDelete) {
                        $table->foreign($column)->references('id')->on('parametros_temas')->onDelete($onDelete);
                    });
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $columnsToRename = [
            'tipo_documento_id' => 'id_tipo_documento',
            'genero_id' => 'id_genero',
            'categoria_id' => 'id_categoria',
            'talla_id' => 'id_talla',
            'ciudad_origen_id' => 'id_ciudad_origen',
            'eps_id' => 'id_eps',
        ];

        foreach ($columnsToRename as $oldName => $newName) {
            if (Schema::hasColumn('personas', $oldName)) {
                $constraintName = "personas_{$oldName}_foreign";
                DB::statement("ALTER TABLE personas DROP CONSTRAINT IF EXISTS {$constraintName}");
            }
        }

        Schema::table('personas', function (Blueprint $table) use ($columnsToRename) {
            foreach ($columnsToRename as $oldName => $newName) {
                if (Schema::hasColumn('personas', $oldName)) {
                    $table->renameColumn($oldName, $newName);
                }
            }
        });

        Schema::table('personas', function (Blueprint $table) {
            if (Schema::hasColumn('personas', 'id_tipo_documento')) {
                $table->foreign('id_tipo_documento')->references('id')->on('parametros_temas')->onDelete('restrict');
            }
            if (Schema::hasColumn('personas', 'id_genero')) {
                $table->foreign('id_genero')->references('id')->on('parametros_temas')->onDelete('restrict');
            }
            if (Schema::hasColumn('personas', 'id_categoria')) {
                $table->foreign('id_categoria')->references('id')->on('parametros_temas')->onDelete('restrict');
            }
            if (Schema::hasColumn('personas', 'id_talla')) {
                $table->foreign('id_talla')->references('id')->on('parametros_temas')->onDelete('set null');
            }
            if (Schema::hasColumn('personas', 'id_ciudad_origen')) {
                $table->foreign('id_ciudad_origen')->references('id')->on('parametros_temas')->onDelete('restrict');
            }
            if (Schema::hasColumn('personas', 'id_eps')) {
                $table->foreign('id_eps')->references('id')->on('parametros_temas')->onDelete('restrict');
            }
        });
    }
};
