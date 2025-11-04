<?php

namespace App\Services;

use App\Models\EstatusDocumento;
use Illuminate\Support\Facades\Log;

class EstatusDocumentoService
{
    /**
     * IDs predefinidos para los estatus básicos
     */
    const ESTATUS_PENDIENTE_ID = '00000000-0000-0000-0000-000000000001';
    const ESTATUS_APROBADO_ID = '00000000-0000-0000-0000-000000000002';
    const ESTATUS_RECHAZADO_ID = '00000000-0000-0000-0000-000000000003';

    /**
     * Estatus básicos que deben existir
     */
    protected array $defaultEstatus = [
        [
            'id' => self::ESTATUS_PENDIENTE_ID,
            'nombre' => 'pendiente'
        ],
        [
            'id' => self::ESTATUS_APROBADO_ID,
            'nombre' => 'aprobado'
        ],
        [
            'id' => self::ESTATUS_RECHAZADO_ID,
            'nombre' => 'rechazado'
        ]
    ];

    /**
     * Verificar y crear estatus básicos si no existen
     */
    public function ensureDefaultEstatus(): void
    {
        foreach ($this->defaultEstatus as $estatusData) {
            $estatus = EstatusDocumento::find($estatusData['id']);
            
            if (!$estatus) {
                try {
                    EstatusDocumento::create([
                        'id' => $estatusData['id'],
                        'nombre' => $estatusData['nombre']
                    ]);
                    Log::info("Estatus documento creado: {$estatusData['nombre']}");
                } catch (\Exception $e) {
                    Log::error("Error al crear estatus {$estatusData['nombre']}: " . $e->getMessage());
                }
            }
        }
    }

    /**
     * Obtener un estatus por su ID
     */
    public function getEstatusById(string $id): ?EstatusDocumento
    {
        return EstatusDocumento::find($id);
    }

    /**
     * Obtener un estatus por su nombre
     */
    public function getEstatusByName(string $nombre): ?EstatusDocumento
    {
        return EstatusDocumento::where('nombre', $nombre)->first();
    }

    /**
     * Obtener el ID del estatus pendiente
     */
    public function getPendienteId(): string
    {
        return self::ESTATUS_PENDIENTE_ID;
    }

    /**
     * Obtener el ID del estatus aprobado
     */
    public function getAprobadoId(): string
    {
        return self::ESTATUS_APROBADO_ID;
    }

    /**
     * Obtener el ID del estatus rechazado
     */
    public function getRechazadoId(): string
    {
        return self::ESTATUS_RECHAZADO_ID;
    }
}

