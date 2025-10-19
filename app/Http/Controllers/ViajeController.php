<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Viaje;
use App\Models\Pasajero;
use App\Models\Taxista;
use App\Models\Taxi;
use App\Models\CalificacionViaje;
use App\Models\CalificacionTaxi;

class ViajeController extends Controller
{
    /**
     * Crear un nuevo viaje
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
            'comentario' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos de entrada inválidos',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            DB::beginTransaction();

            $viaje = Viaje::create([
                'id' => Str::uuid(),
                'id_pasajero' => $request->id_pasajero,
                'lat_salida' => $request->salida['lat'],
                'lon_salida' => $request->salida['lon'],
                'lat_destino' => $request->destino['lat'],
                'lon_destino' => $request->destino['lon'],
                'estado' => Viaje::ESTADO_PENDIENTE,
                'comentario' => $request->comentario,
                'id_taxi' => null // Se asignará cuando un taxista acepte
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Viaje creado exitosamente',
                'data' => [
                    'id' => $viaje->id,
                    'estado' => $viaje->estado,
                    'salida' => [
                        'lat' => $viaje->lat_salida,
                        'lon' => $viaje->lon_salida
                    ],
                    'destino' => [
                        'lat' => $viaje->lat_destino,
                        'lon' => $viaje->lon_destino
                    ],
                    'comentario' => $viaje->comentario,
                    'created_at' => $viaje->created_at
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
     * Obtener viajes del pasajero
     */
    public function misViajesPasajero(Request $request): JsonResponse
    {
        $pasajeroId = $request->user()->pasajero->id ?? null;

        if (!$pasajeroId) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no es un pasajero'
            ], 403);
        }

        $viajes = Viaje::delPasajero($pasajeroId)
            ->with(['taxi.taxista.usuario', 'calificacion'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $viajes->map(function ($viaje) {
                return [
                    'id' => $viaje->id,
                    'estado' => $viaje->estado,
                    'salida' => [
                        'lat' => $viaje->lat_salida,
                        'lon' => $viaje->lon_salida
                    ],
                    'destino' => [
                        'lat' => $viaje->lat_destino,
                        'lon' => $viaje->lon_destino
                    ],
                    'taxi' => $viaje->taxi ? [
                        'id' => $viaje->taxi->id,
                        'numero_taxi' => $viaje->taxi->numero_taxi,
                        'taxista' => [
                            'nombre' => $viaje->taxi->taxista->usuario->nombre ?? 'N/A',
                            'telefono' => $viaje->taxi->taxista->usuario->telefono ?? 'N/A'
                        ]
                    ] : null,
                    'comentario' => $viaje->comentario,
                    'calificacion' => $viaje->calificacion,
                    'created_at' => $viaje->created_at,
                    'updated_at' => $viaje->updated_at
                ];
            })
        ]);
    }

    /**
     * Cancelar viaje
     */
    public function cancelarViaje(Request $request, $id): JsonResponse
    {
        $pasajeroId = $request->user()->pasajero->id ?? null;

        if (!$pasajeroId) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no es un pasajero'
            ], 403);
        }

        $viaje = Viaje::where('id', $id)
            ->where('id_pasajero', $pasajeroId)
            ->first();

        if (!$viaje) {
            return response()->json([
                'success' => false,
                'message' => 'Viaje no encontrado'
            ], 404);
        }

        if (!in_array($viaje->estado, [Viaje::ESTADO_PENDIENTE, Viaje::ESTADO_ACEPTADO])) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede cancelar un viaje en estado: ' . $viaje->estado
            ], 400);
        }

        try {
            $viaje->update(['estado' => Viaje::ESTADO_CANCELADO]);

            return response()->json([
                'success' => true,
                'message' => 'Viaje cancelado exitosamente',
                'data' => [
                    'id' => $viaje->id,
                    'estado' => $viaje->estado
                ]
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
     * Calificar viaje
     */
    public function calificarViaje(Request $request, $id): JsonResponse
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
            ], 400);
        }

        $pasajeroId = $request->user()->pasajero->id ?? null;

        if (!$pasajeroId) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no es un pasajero'
            ], 403);
        }

        $viaje = Viaje::where('id', $id)
            ->where('id_pasajero', $pasajeroId)
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
            ], 400);
        }

        try {
            DB::beginTransaction();

            // Crear calificación del viaje
            CalificacionViaje::create([
                'id' => Str::uuid(),
                'calificacion' => $request->calificacion,
                'id_pasajero' => $pasajeroId,
                'id_viaje' => $viaje->id,
                'comentario' => $request->comentario
            ]);

            // Crear calificación del taxista
            if ($viaje->taxi && $viaje->taxi->taxista) {
                CalificacionTaxi::create([
                    'id' => Str::uuid(),
                    'calificacion' => $request->calificacion,
                    'id_taxista' => $viaje->taxi->taxista->id,
                    'id_pasajero' => $pasajeroId,
                    'comentario' => $request->comentario
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Viaje calificado exitosamente',
                'data' => [
                    'calificacion' => $request->calificacion,
                    'comentario' => $request->comentario
                ]
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

    /**
     * Obtener viajes disponibles para taxistas
     */
    public function viajesDisponibles(Request $request): JsonResponse
    {
        $taxistaId = $request->user()->taxista->id ?? null;

        if (!$taxistaId) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no es un taxista'
            ], 403);
        }

        $viajes = Viaje::disponibles()
            ->with(['pasajero.usuario'])
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $viajes->map(function ($viaje) {
                return [
                    'id' => $viaje->id,
                    'salida' => [
                        'lat' => $viaje->lat_salida,
                        'lon' => $viaje->lon_salida
                    ],
                    'destino' => [
                        'lat' => $viaje->lat_destino,
                        'lon' => $viaje->lon_destino
                    ],
                    'pasajero' => [
                        'nombre' => $viaje->pasajero->usuario->nombre ?? 'N/A',
                        'telefono' => $viaje->pasajero->usuario->telefono ?? 'N/A'
                    ],
                    'comentario' => $viaje->comentario,
                    'created_at' => $viaje->created_at
                ];
            })
        ]);
    }

    /**
     * Aceptar viaje
     */
    public function aceptarViaje(Request $request, $id): JsonResponse
    {
        $taxistaId = $request->user()->taxista->id ?? null;

        if (!$taxistaId) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no es un taxista'
            ], 403);
        }

        $viaje = Viaje::disponibles()->find($id);

        if (!$viaje) {
            return response()->json([
                'success' => false,
                'message' => 'Viaje no disponible'
            ], 404);
        }

        // Obtener el taxi del taxista
        $taxi = Taxi::where('id_taxista', $taxistaId)->first();

        if (!$taxi) {
            return response()->json([
                'success' => false,
                'message' => 'Taxista no tiene taxi registrado'
            ], 400);
        }

        try {
            DB::beginTransaction();

            $viaje->update([
                'id_taxi' => $taxi->id,
                'estado' => Viaje::ESTADO_ACEPTADO
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Viaje aceptado exitosamente',
                'data' => [
                    'id' => $viaje->id,
                    'estado' => $viaje->estado,
                    'taxi_id' => $taxi->id
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al aceptar el viaje',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Rechazar viaje
     */
    public function rechazarViaje(Request $request, $id): JsonResponse
    {
        $taxistaId = $request->user()->taxista->id ?? null;

        if (!$taxistaId) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no es un taxista'
            ], 403);
        }

        $viaje = Viaje::disponibles()->find($id);

        if (!$viaje) {
            return response()->json([
                'success' => false,
                'message' => 'Viaje no disponible'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Viaje rechazado (no se requiere acción en BD)'
        ]);
    }

    /**
     * Completar viaje
     */
    public function completarViaje(Request $request, $id): JsonResponse
    {
        $taxistaId = $request->user()->taxista->id ?? null;

        if (!$taxistaId) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no es un taxista'
            ], 403);
        }

        $viaje = Viaje::where('id', $id)
            ->whereHas('taxi', function($q) use ($taxistaId) {
                $q->where('id_taxista', $taxistaId);
            })
            ->whereIn('estado', [Viaje::ESTADO_ACEPTADO, Viaje::ESTADO_EN_CURSO])
            ->first();

        if (!$viaje) {
            return response()->json([
                'success' => false,
                'message' => 'Viaje no encontrado o no autorizado'
            ], 404);
        }

        try {
            $viaje->update(['estado' => Viaje::ESTADO_COMPLETADO]);

            return response()->json([
                'success' => true,
                'message' => 'Viaje completado exitosamente',
                'data' => [
                    'id' => $viaje->id,
                    'estado' => $viaje->estado
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al completar el viaje',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener viajes del taxista
     */
    public function misViajesTaxista(Request $request): JsonResponse
    {
        $taxistaId = $request->user()->taxista->id ?? null;

        if (!$taxistaId) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no es un taxista'
            ], 403);
        }

        $viajes = Viaje::delTaxista($taxistaId)
            ->with(['pasajero.usuario', 'calificacion'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $viajes->map(function ($viaje) {
                return [
                    'id' => $viaje->id,
                    'estado' => $viaje->estado,
                    'salida' => [
                        'lat' => $viaje->lat_salida,
                        'lon' => $viaje->lon_salida
                    ],
                    'destino' => [
                        'lat' => $viaje->lat_destino,
                        'lon' => $viaje->lon_destino
                    ],
                    'pasajero' => [
                        'nombre' => $viaje->pasajero->usuario->nombre ?? 'N/A',
                        'telefono' => $viaje->pasajero->usuario->telefono ?? 'N/A'
                    ],
                    'comentario' => $viaje->comentario,
                    'calificacion' => $viaje->calificacion,
                    'created_at' => $viaje->created_at,
                    'updated_at' => $viaje->updated_at
                ];
            })
        ]);
    }

    /**
     * Obtener estado de viaje
     */
    public function estadoViaje(Request $request, $id): JsonResponse
    {
        $viaje = Viaje::with(['taxi.taxista.usuario', 'pasajero.usuario', 'calificacion'])
            ->find($id);

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
                'salida' => [
                    'lat' => $viaje->lat_salida,
                    'lon' => $viaje->lon_salida
                ],
                'destino' => [
                    'lat' => $viaje->lat_destino,
                    'lon' => $viaje->lon_destino
                ],
                'ubicacion_actual' => $viaje->lat_actual && $viaje->lon_actual ? [
                    'lat' => $viaje->lat_actual,
                    'lon' => $viaje->lon_actual
                ] : null,
                'taxi' => $viaje->taxi ? [
                    'id' => $viaje->taxi->id,
                    'numero_taxi' => $viaje->taxi->numero_taxi,
                    'taxista' => [
                        'nombre' => $viaje->taxi->taxista->usuario->nombre ?? 'N/A',
                        'telefono' => $viaje->taxi->taxista->usuario->telefono ?? 'N/A'
                    ]
                ] : null,
                'pasajero' => [
                    'nombre' => $viaje->pasajero->usuario->nombre ?? 'N/A',
                    'telefono' => $viaje->pasajero->usuario->telefono ?? 'N/A'
                ],
                'comentario' => $viaje->comentario,
                'calificacion' => $viaje->calificacion,
                'created_at' => $viaje->created_at,
                'updated_at' => $viaje->updated_at
            ]
        ]);
    }

    /**
     * Actualizar ubicación en tiempo real
     */
    public function actualizarUbicacion(Request $request, $id): JsonResponse
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
            ], 400);
        }

        $taxistaId = $request->user()->taxista->id ?? null;

        if (!$taxistaId) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no es un taxista'
            ], 403);
        }

        $viaje = Viaje::where('id', $id)
            ->whereHas('taxi', function($q) use ($taxistaId) {
                $q->where('id_taxista', $taxistaId);
            })
            ->whereIn('estado', [Viaje::ESTADO_ACEPTADO, Viaje::ESTADO_EN_CURSO])
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

            return response()->json([
                'success' => true,
                'message' => 'Ubicación actualizada exitosamente',
                'data' => [
                    'id' => $viaje->id,
                    'ubicacion_actual' => [
                        'lat' => $viaje->lat_actual,
                        'lon' => $viaje->lon_actual
                    ]
                ]
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







