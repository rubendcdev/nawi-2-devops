<?php

namespace App\Http\Controllers;

use App\Models\Pasajero;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PasajeroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $pasajeros = Pasajero::with(['genero', 'idioma'])->get();
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
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'ine' => 'nullable|string|max:255',
            'foto' => 'nullable|string|max:255',
            'correo' => 'required|email|max:105',
            'num_telefono' => 'nullable|string|max:20',
            'contrasena' => 'required|string|max:10',
            'discapacidad' => 'nullable|boolean',
            'id_genero' => 'required|exists:generos,id_genero',
            'id_dioma' => 'required|exists:idiomas,id_dioma'
        ]);

        $pasajero = Pasajero::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Pasajero creado exitosamente',
            'data' => $pasajero->load(['genero', 'idioma'])
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $pasajero = Pasajero::with(['genero', 'idioma'])->find($id);

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
            'nombre' => 'sometimes|required|string|max:100',
            'apellidos' => 'sometimes|required|string|max:100',
            'ine' => 'nullable|string|max:255',
            'foto' => 'nullable|string|max:255',
            'correo' => 'sometimes|required|email|max:105',
            'num_telefono' => 'nullable|string|max:20',
            'contrasena' => 'sometimes|required|string|max:10',
            'discapacidad' => 'nullable|boolean',
            'id_genero' => 'sometimes|required|exists:generos,id_genero',
            'id_dioma' => 'sometimes|required|exists:idiomas,id_dioma'
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
            'data' => $pasajero->load(['genero', 'idioma'])
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
