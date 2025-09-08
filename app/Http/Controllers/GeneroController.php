<?php

namespace App\Http\Controllers;

use App\Models\Genero;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class GeneroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $generos = Genero::all();
        return response()->json([
            'success' => true,
            'data' => $generos
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'tipo' => 'required|string|max:45'
        ]);

        $genero = Genero::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Género creado exitosamente',
            'data' => $genero
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $genero = Genero::find($id);

        if (!$genero) {
            return response()->json([
                'success' => false,
                'message' => 'Género no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $genero
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $request->validate([
            'tipo' => 'required|string|max:45'
        ]);

        $genero = Genero::find($id);

        if (!$genero) {
            return response()->json([
                'success' => false,
                'message' => 'Género no encontrado'
            ], 404);
        }

        $genero->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Género actualizado exitosamente',
            'data' => $genero
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $genero = Genero::find($id);

        if (!$genero) {
            return response()->json([
                'success' => false,
                'message' => 'Género no encontrado'
            ], 404);
        }

        $genero->delete();

        return response()->json([
            'success' => true,
            'message' => 'Género eliminado exitosamente'
        ]);
    }
}
