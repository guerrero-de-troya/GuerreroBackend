<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // permisos para autenticación
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

        foreach ($authPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Crear roles
        $usuarioRole = Role::firstOrCreate(['name' => 'usuario']);
        $adminRole = Role::firstOrCreate(['name' => 'Administrador']);
        $superAdminRole = Role::firstOrCreate(['name' => 'SuperAdministrador']);

        $usuarioRole->givePermissionTo($authPermissions);

        $adminRole->givePermissionTo($authPermissions);

        // SuperAdministrador tiene todos los permisos
        $superAdminRole->givePermissionTo(Permission::all());

        $this->command->info('Roles y permisos creados exitosamente');
    }
}
