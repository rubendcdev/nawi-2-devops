<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalificacionViaje extends Model
{
    use HasFactory;

    protected $table = 'calificacion_viajes';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'calificacion',
        'id_pasajero',
        'id_viaje',
        'comentario'
    ];

    protected $casts = [
        'calificacion' => 'integer'
    ];

    // Relaciones
    public function pasajero(): BelongsTo
    {
        return $this->belongsTo(Pasajero::class, 'id_pasajero');
    }

    public function viaje(): BelongsTo
    {
        return $this->belongsTo(Viaje::class, 'id_viaje');
    }
}
