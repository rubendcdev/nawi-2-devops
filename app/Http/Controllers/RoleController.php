<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->middleware('auth:api');
        $this->roleService = $roleService;
    }

    /**
     * GET /api/roles
     * Obtener todos los roles
     */
    public function index(): JsonResponse
    {
        $roles = $this->roleService->getAllRoles();

        return response()->json([
            'success' => true,
            'data' => $roles
        ]);
    }

    /**
     * POST /api/roles
     * Crear un nuevo rol
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:45|unique:roles,nombre'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos de entrada inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $role = $this->roleService->createRole($request->nombre);

            return response()->json([
                'success' => true,
                'message' => 'Rol creado exitosamente',
                'data' => $role
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el rol',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /api/roles/{id}
     * Obtener un rol específico
     */
    public function show(string $id): JsonResponse
    {
        $role = $this->roleService->getRoleById($id);

        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => 'Rol no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $role
        ]);
    }

    /**
     * POST /api/roles/ensure-defaults
     * Asegurar que los roles básicos existan (crearlos si no existen)
     */
    public function ensureDefaults(): JsonResponse
    {
        try {
            $this->roleService->ensureDefaultRoles();

            return response()->json([
                'success' => true,
                'message' => 'Roles básicos verificados y creados si era necesario'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al verificar roles',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

