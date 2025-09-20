<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasajero extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pasajero';
    protected $fillable = [
        'nombre',
        'apellidos',
        'ine',
        'foto',
        'correo',
        'num_telefono',
        'contrasena',
        'discapacidad',
        'id_genero',
        'id_dioma'
    ];

    protected $casts = [
        'discapacidad' => 'boolean',
    ];

    public function genero()
    {
        return $this->belongsTo(Genero::class, 'id_genero');
    }

    public function idioma()
    {
        return $this->belongsTo(Idioma::class, 'id_dioma');
    }
}
