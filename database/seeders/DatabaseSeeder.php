<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeders esenciales
        $this->call([
            RolePermissionSeeder::class,
            TemaSeeder::class,
            ParametroSeeder::class,
        ]);

        // Crear usuario super administrador solo si está habilitado
        if (env('CREATE_ADMIN_USER', true)) {
            $this->call(SuperAdminUserSeeder::class);
        }
    }
}
