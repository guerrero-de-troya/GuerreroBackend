<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Persona;
use App\Models\Parametro;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener parámetros necesarios (deben existir después de ParametroSeeder)
        $tipoDocumentoCC = Parametro::whereHas('tema', function ($query) {
            $query->where('name', 'TIPO DOCUMENTO');
        })->where('name', 'CÉDULA DE CIUDADANÍA')->first();

        $generoMasculino = Parametro::whereHas('tema', function ($query) {
            $query->where('name', 'GENERO');
        })->where('name', 'MASCULINO')->first();

        $nivel = Parametro::whereHas('tema', function ($query) {
            $query->where('name', 'NIVEL');
        })->first();

        $tallaM = Parametro::whereHas('tema', function ($query) {
            $query->where('name', 'TALLA');
        })->where('name', 'M')->first();

        $eps = Parametro::whereHas('tema', function ($query) {
            $query->where('name', 'EPS');
        })->where('name', 'NUEVA EPS')->first();

        // Crear persona para el super administrador si no existe
        $persona = Persona::firstOrCreate(
            ['numero_documento' => env('ADMIN_DOCUMENTO', '00000000')],
            [
                'primer_nombre' => env('ADMIN_NOMBRE', 'ADMINISTRADOR'),
                'segundo_nombre' => env('ADMIN_SEGUNDO_NOMBRE'),
                'primer_apellido' => env('ADMIN_APELLIDO', 'SISTEMA'),
                'segundo_apellido' => env('ADMIN_SEGUNDO_APELLIDO'),
                'tipo_documento_id' => $tipoDocumentoCC?->id ?? 1,
                'telefono' => env('ADMIN_TELEFONO', '0000000000'),
                'edad' => env('ADMIN_EDAD', 30),
                'genero_id' => $generoMasculino?->id ?? 1,
                'camisa' => env('ADMIN_CAMISA'),
                'talla_id' => $tallaM?->id,
                'eps_id' => $eps?->id,
                'departamento_id' => null,
                'municipio_id' => null,
                'pais_id' => null,
                'nivel_id' => $nivel?->id,
            ]
        );

        // Crear usuario super administrador solo si no existe
        $superAdmin = User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@example.com')],
            [
                'password' => Hash::make(env('ADMIN_PASSWORD', 'Admin123!')),
                'email_verified_at' => now(),
                'persona_id' => $persona->id,
            ]
        );

        // Asignar rol SuperAdministrador si no lo tiene
        if (!$superAdmin->hasRole('SuperAdministrador')) {
            $superAdmin->assignRole('SuperAdministrador');
            $this->command->info('Rol SuperAdministrador asignado a ' . $superAdmin->email);
        } else {
            $this->command->info('Usuario super administrador ya existe: ' . $superAdmin->email);
        }
    }
}
