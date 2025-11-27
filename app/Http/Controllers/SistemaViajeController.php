<?php

namespace App\Http\Controllers;

use App\Models\Viaje;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class SistemaViajeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * GET /viaje/estado/{viajeId}
     * Obtener el estado actual de un viaje
     */
    public function estadoViaje(Request $request, string $viajeId): JsonResponse
    {
        $viaje = Viaje::with(['taxi.taxista.usuario', 'taxi', 'pasajero.usuario'])
            ->find($viajeId);

        if (!$viaje) {
            return response()->json([
                'success' => false,
                'message' => 'Viaje no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $viaje->id,
                'estado' => $viaje->estado,
                'id_pasajero' => $viaje->id_pasajero,
                'pasajero' => $viaje->pasajero && $viaje->pasajero->usuario ? [
                    'nombre' => $viaje->pasajero->usuario->nombre,
                    'apellido' => $viaje->pasajero->usuario->apellido,
                    'email' => $viaje->pasajero->usuario->email
                ] : null,
                'id_taxista' => $viaje->id_taxista ?? ($viaje->taxi ? $viaje->taxi->taxista->id : null),
                'taxista' => $viaje->taxi && $viaje->taxi->taxista && $viaje->taxi->taxista->usuario ? [
                    'id' => $viaje->taxi->taxista->id,
                    'nombre' => $viaje->taxi->taxista->usuario->nombre,
                    'apellido' => $viaje->taxi->taxista->usuario->apellido,
                    'numero_taxi' => $viaje->taxi ? $viaje->taxi->numero_taxi : null,
                    'taxi' => $viaje->taxi ? [
                        'id' => $viaje->taxi->id,
                        'marca' => $viaje->taxi->marca,
                        'modelo' => $viaje->taxi->modelo,
                        'numero_taxi' => $viaje->taxi->numero_taxi
                    ] : null
                ] : null,
                'salida' => [
                    'lat' => $viaje->latitud_origen,
                    'lon' => $viaje->longitud_origen
                ],
                'destino' => [
                    'lat' => $viaje->latitud_destino,
                    'lon' => $viaje->longitud_destino
                ],
                'timestamp' => $viaje->updated_at->getTimestamp() * 1000
            ]
        ]);
    }

    /**
     * POST /viaje/actualizar-ubicacion/{viajeId}
     * Actualizar la ubicación del taxista durante un viaje
     */
    public function actualizarUbicacion(Request $request, string $viajeId): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'lat' => 'required|numeric|between:-90,90',
            'lon' => 'required|numeric|between:-180,180'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos de ubicación inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        $taxista = $request->user()->taxista;

        if (!$taxista) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no es un taxista'
            ], 403);
        }

        $viaje = Viaje::where('id', $viajeId)
            ->where(function($query) use ($taxista) {
                $query->where('id_taxista', $taxista->id)
                      ->orWhereHas('taxi', function($q) use ($taxista) {
                          $q->where('id_taxista', $taxista->id);
                      });
            })
            ->whereIn('estado', [Viaje::ESTADO_ACEPTADO, Viaje::ESTADO_EN_PROGRESO])
            ->first();

        if (!$viaje) {
            return response()->json([
                'success' => false,
                'message' => 'Viaje no encontrado o no autorizado'
            ], 404);
        }

        try {
            $viaje->update([
                'lat_actual' => $request->lat,
                'lon_actual' => $request->lon
            ]);

            // TODO: Aquí se puede agregar la actualización a Firebase para tiempo real
            // FirebaseService::updateLocation($viajeId, $request->lat, $request->lon);

            return response()->json([
                'success' => true,
                'message' => 'Ubicación actualizada exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la ubicación',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

