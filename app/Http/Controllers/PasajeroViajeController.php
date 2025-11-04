<?php

namespace App\Http\Controllers;

use App\Models\Viaje;
use App\Models\Pasajero;
use App\Models\CalificacionViaje;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PasajeroViajeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * POST /pasajero/crear-viaje
     * Crear un nuevo viaje (con o sin taxista específico)
     */
    public function crearViaje(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id_pasajero' => 'required|string|exists:pasajeros,id',
            'salida' => 'required|array',
            'salida.lat' => 'required|numeric|between:-90,90',
            'salida.lon' => 'required|numeric|between:-180,180',
            'destino' => 'required|array',
            'destino.lat' => 'required|numeric|between:-90,90',
            'destino.lon' => 'required|numeric|between:-180,180',
            'id_taxista' => 'nullable|string|exists:taxistas,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos de entrada inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        $pasajero = Pasajero::find($request->id_pasajero);
        if (!$pasajero) {
            return response()->json([
                'success' => false,
                'message' => 'Pasajero no encontrado'
            ], 404);
        }

        // Verificar que el pasajero sea el usuario autenticado
        if ($request->user()->id !== $pasajero->id_usuario) {
            return response()->json([
                'success' => false,
                'message' => 'No autorizado'
            ], 403);
        }

        try {
            DB::beginTransaction();

            // Obtener direcciones - por ahora usar "Origen" y "Destino" como placeholder
            // TODO: Implementar geocodificación inversa para obtener direcciones reales
            // Se puede usar la API de Google Maps con reverse geocoding
            $direccionOrigen = 'Origen';
            $direccionDestino = 'Destino';
            
            // Intentar obtener direcciones reales (si el servicio lo soporta)
            try {
                // Por ahora usamos placeholders, pero aquí se puede agregar la lógica de reverse geocoding
            } catch (\Exception $e) {
                // Si falla, usar placeholders
            }

            $viaje = Viaje::create([
                'id' => Str::uuid(),
                'id_pasajero' => $request->id_pasajero,
                'id_taxista' => $request->id_taxista,
                'latitud_origen' => $request->salida['lat'],
                'longitud_origen' => $request->salida['lon'],
                'direccion_origen' => $direccionOrigen['success'] ? $direccionOrigen['formatted_address'] : 'Origen',
                'latitud_destino' => $request->destino['lat'],
                'longitud_destino' => $request->destino['lon'],
                'direccion_destino' => $direccionDestino['success'] ? $direccionDestino['formatted_address'] : 'Destino',
                'estado' => Viaje::ESTADO_SOLICITADO,
                'id_taxi' => null
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Viaje creado exitosamente',
                'data' => [
                    'id' => $viaje->id,
                    'id_pasajero' => $viaje->id_pasajero,
                    'id_taxista' => $viaje->id_taxista,
                    'latitud_origen' => $viaje->latitud_origen,
                    'longitud_origen' => $viaje->longitud_origen,
                    'direccion_origen' => $viaje->direccion_origen,
                    'latitud_destino' => $viaje->latitud_destino,
                    'longitud_destino' => $viaje->longitud_destino,
                    'direccion_destino' => $viaje->direccion_destino,
                    'estado' => $viaje->estado,
                    'fecha_creacion' => $viaje->created_at->toIso8601String()
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el viaje',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /pasajero/mis-viajes
     * Obtener todos los viajes del pasajero autenticado
     */
    public function misViajes(Request $request): JsonResponse
    {
        $pasajero = $request->user()->pasajero;

        if (!$pasajero) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no es un pasajero'
            ], 403);
        }

        $viajes = Viaje::where('id_pasajero', $pasajero->id)
            ->with(['taxi.taxista.usuario', 'calificacion'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $viajes->map(function ($viaje) {
                return [
                    'id' => $viaje->id,
                    'pasajero_id' => $viaje->id_pasajero,
                    'taxista_id' => $viaje->taxi ? $viaje->taxi->taxista->id : null,
                    'latitud_origen' => $viaje->latitud_origen,
                    'longitud_origen' => $viaje->longitud_origen,
                    'direccion_origen' => $viaje->direccion_origen,
                    'latitud_destino' => $viaje->latitud_destino,
                    'longitud_destino' => $viaje->longitud_destino,
                    'direccion_destino' => $viaje->direccion_destino,
                    'estado' => $viaje->estado,
                    'fecha_creacion' => $viaje->created_at->toIso8601String(),
                    'fecha_aceptacion' => $viaje->fecha_aceptacion ? $viaje->fecha_aceptacion->toIso8601String() : null,
                    'fecha_completado' => $viaje->fecha_completado ? $viaje->fecha_completado->toIso8601String() : null,
                    'calificacion' => $viaje->calificacion ? $viaje->calificacion->calificacion : null,
                    'comentario' => $viaje->calificacion ? $viaje->calificacion->comentario : null
                ];
            })
        ]);
    }

    /**
     * POST /pasajero/cancelar-viaje/{viajeId}
     * Cancelar un viaje solicitado
     */
    public function cancelarViaje(Request $request, string $viajeId): JsonResponse
    {
        $pasajero = $request->user()->pasajero;

        if (!$pasajero) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no es un pasajero'
            ], 403);
        }

        $viaje = Viaje::where('id', $viajeId)
            ->where('id_pasajero', $pasajero->id)
            ->first();

        if (!$viaje) {
            return response()->json([
                'success' => false,
                'message' => 'Viaje no encontrado'
            ], 404);
        }

        // Solo puede cancelar si el estado es solicitado o aceptado
        if (!in_array($viaje->estado, [Viaje::ESTADO_SOLICITADO, Viaje::ESTADO_ACEPTADO])) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede cancelar un viaje en estado: ' . $viaje->estado
            ], 422);
        }

        try {
            $viaje->update(['estado' => Viaje::ESTADO_CANCELADO]);

            return response()->json([
                'success' => true,
                'message' => 'Viaje cancelado exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cancelar el viaje',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * POST /pasajero/calificar-viaje/{viajeId}
     * Calificar un viaje completado
     */
    public function calificarViaje(Request $request, string $viajeId): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'calificacion' => 'required|integer|between:1,5',
            'comentario' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos de entrada inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        $pasajero = $request->user()->pasajero;

        if (!$pasajero) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no es un pasajero'
            ], 403);
        }

        $viaje = Viaje::where('id', $viajeId)
            ->where('id_pasajero', $pasajero->id)
            ->where('estado', Viaje::ESTADO_COMPLETADO)
            ->first();

        if (!$viaje) {
            return response()->json([
                'success' => false,
                'message' => 'Viaje no encontrado o no completado'
            ], 404);
        }

        // Verificar si ya fue calificado
        if ($viaje->calificacion) {
            return response()->json([
                'success' => false,
                'message' => 'Este viaje ya fue calificado'
            ], 422);
        }

        try {
            DB::beginTransaction();

            CalificacionViaje::create([
                'id' => Str::uuid(),
                'calificacion' => $request->calificacion,
                'id_pasajero' => $pasajero->id,
                'id_viaje' => $viaje->id,
                'comentario' => $request->comentario
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Viaje calificado exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al calificar el viaje',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

