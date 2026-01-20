<?php

namespace Database\Seeders;

use App\Models\Tema;
use Illuminate\Database\Seeder;

class TemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $temas = [
            'TIPO DOCUMENTO',
            'TALLA',
            'GENERO',
            'EPS',
            'NIVEL',
        ];

        foreach ($temas as $tema) {
            Tema::firstOrCreate(
                ['name' => $tema],
                ['name' => $tema]
            );
        }
    }
}
