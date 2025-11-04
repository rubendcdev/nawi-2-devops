<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstatusDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar si los estatus ya existen para evitar duplicados
        $existingEstatus = DB::table('estatus_documentos')->count();
        if ($existingEstatus > 0) {
            return; // Ya existen estatus, no insertar de nuevo
        }

        // Usar IDs UUID consistentes para los estatus
        $estatus = [
            [
                'id' => '00000000-0000-0000-0000-000000000001', // Pendiente
                'nombre' => 'pendiente'
            ],
            [
                'id' => '00000000-0000-0000-0000-000000000002', // Aprobado
                'nombre' => 'aprobado'
            ],
            [
                'id' => '00000000-0000-0000-0000-000000000003', // Rechazado
                'nombre' => 'rechazado'
            ]
        ];

        foreach ($estatus as $status) {
            DB::table('estatus_documentos')->insert([
                'id' => $status['id'],
                'nombre' => $status['nombre'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
