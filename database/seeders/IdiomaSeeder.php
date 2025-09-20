<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Idioma;

class IdiomaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $idiomas = [
            ['tipo' => 'Español'],
            ['tipo' => 'Inglés'],
            ['tipo' => 'Francés'],
            ['tipo' => 'Alemán'],
            ['tipo' => 'Italiano'],
            ['tipo' => 'Portugués'],
            ['tipo' => 'Chino'],
            ['tipo' => 'Japonés']
        ];

        foreach ($idiomas as $idioma) {
            Idioma::create($idioma);
        }
    }
}
