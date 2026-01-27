<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Resetear caché de permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permisos para autenticación
        $authPermissions = [
            'auth.register',
            'auth.login',
            'auth.logout',
            'auth.me',
            'auth.verify-email',
            'auth.resend-verification',
            'auth.forgot-password',
            'auth.reset-password',
        ];

        // Crear permisos solo si no existen
        foreach ($authPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Crear roles solo si no existen
        $usuarioRole = Role::firstOrCreate(['name' => 'usuario']);
        $adminRole = Role::firstOrCreate(['name' => 'Administrador']);
        $superAdminRole = Role::firstOrCreate(['name' => 'SuperAdministrador']);

        // Sincronizar permisos (sync no duplica, es idempotente)
        $usuarioRole->syncPermissions($authPermissions);
        $adminRole->syncPermissions($authPermissions);
        
        // SuperAdministrador tiene todos los permisos
        $superAdminRole->syncPermissions(Permission::all());

        $this->command->info('Roles y permisos sincronizados exitosamente');
    }
}
