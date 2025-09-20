<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxista extends Model
{
    use HasFactory;

    protected $table = 'taxistas';
    protected $primaryKey = 'id_taxista';

    protected $fillable = [
        'nombre',
        'apellidos',
        'edad',
        'ine',
        'permiso',
        'licencia',
        'num_telefono',
        'contrasena',
        'foto_conductor',
        'foto_taxi',
        'ubicacion_actual',
        'estado',
        'turno',
        'id_carro',
        'id_genero',
        'id_idioma',
    ];

    protected $hidden = [
        'contrasena',
    ];

    public function taxi()
    {
        return $this->belongsTo(Taxi::class);
    }
    public function carro() 
    {
        return $this->belongsTo(Taxi::class, 'id_carro', 'id_carro');
    }

}
