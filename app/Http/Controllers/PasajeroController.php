<?php

namespace App\Http\Controllers;

use App\Models\Pasajero;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PasajeroController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $pasajeros = Pasajero::with(['usuario.rol'])->get();
        return response()->json([
            'success' => true,
            'data' => $pasajeros
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'id_usuario' => 'required|string|exists:usuarios,id'
        ]);

        $pasajero = Pasajero::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Pasajero creado exitosamente',
            'data' => $pasajero->load(['usuario.rol'])
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $pasajero = Pasajero::with(['usuario.rol'])->find($id);

        if (!$pasajero) {
            return response()->json([
                'success' => false,
                'message' => 'Pasajero no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $pasajero
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $request->validate([
            'id_usuario' => 'sometimes|required|string|exists:usuarios,id'
        ]);

        $pasajero = Pasajero::find($id);

        if (!$pasajero) {
            return response()->json([
                'success' => false,
                'message' => 'Pasajero no encontrado'
            ], 404);
        }

        $pasajero->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Pasajero actualizado exitosamente',
            'data' => $pasajero->load(['usuario.rol'])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $pasajero = Pasajero::find($id);

        if (!$pasajero) {
            return response()->json([
                'success' => false,
                'message' => 'Pasajero no encontrado'
            ], 404);
        }

        $pasajero->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pasajero eliminado exitosamente'
        ]);
    }
}
