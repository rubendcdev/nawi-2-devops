<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar si los roles ya existen para evitar duplicados
        $existingRoles = DB::table('roles')->count();
        if ($existingRoles > 0) {
            return; // Ya existen roles, no insertar de nuevo
        }

        // Usar IDs UUID consistentes para los roles
        $roles = [
            [
                'id' => '00000000-0000-0000-0000-000000000001', // Admin
                'nombre' => 'admin'
            ],
            [
                'id' => '00000000-0000-0000-0000-000000000002', // Pasajero
                'nombre' => 'pasajero'
            ],
            [
                'id' => '00000000-0000-0000-0000-000000000003', // Taxista
                'nombre' => 'taxista'
            ]
        ];

        foreach ($roles as $role) {
            DB::table('roles')->insert([
                'id' => $role['id'],
                'nombre' => $role['nombre'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
