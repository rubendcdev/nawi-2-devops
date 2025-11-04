<?php

namespace App\Services;

use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoleService
{
    /**
     * IDs predefinidos para los roles básicos
     */
    const ROLE_ADMIN_ID = '00000000-0000-0000-0000-000000000001';
    const ROLE_PASAJERO_ID = '00000000-0000-0000-0000-000000000002';
    const ROLE_TAXISTA_ID = '00000000-0000-0000-0000-000000000003';

    /**
     * Roles básicos que deben existir
     */
    protected array $defaultRoles = [
        [
            'id' => self::ROLE_ADMIN_ID,
            'nombre' => 'admin'
        ],
        [
            'id' => self::ROLE_PASAJERO_ID,
            'nombre' => 'pasajero'
        ],
        [
            'id' => self::ROLE_TAXISTA_ID,
            'nombre' => 'taxista'
        ]
    ];

    /**
     * Verificar y crear roles básicos si no existen
     */
    public function ensureDefaultRoles(): void
    {
        foreach ($this->defaultRoles as $roleData) {
            $role = Role::find($roleData['id']);
            
            if (!$role) {
                try {
                    Role::create([
                        'id' => $roleData['id'],
                        'nombre' => $roleData['nombre']
                    ]);
                    Log::info("Rol creado: {$roleData['nombre']}");
                } catch (\Exception $e) {
                    Log::error("Error al crear rol {$roleData['nombre']}: " . $e->getMessage());
                }
            }
        }
    }

    /**
     * Obtener un rol por su ID
     */
    public function getRoleById(string $id): ?Role
    {
        return Role::find($id);
    }

    /**
     * Obtener un rol por su nombre
     */
    public function getRoleByName(string $nombre): ?Role
    {
        return Role::where('nombre', $nombre)->first();
    }

    /**
     * Crear un nuevo rol
     */
    public function createRole(string $nombre, ?string $id = null): Role
    {
        return Role::create([
            'id' => $id ?? \Illuminate\Support\Str::uuid(),
            'nombre' => $nombre
        ]);
    }

    /**
     * Obtener todos los roles
     */
    public function getAllRoles()
    {
        return Role::all();
    }
}

