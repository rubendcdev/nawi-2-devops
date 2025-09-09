<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carro extends Model
{
    use HasFactory;

    protected $table = 'carros'; // nombre de la tabla

    protected $primaryKey = 'id_carro'; // llave primaria

    public $timestamps = true; // si quieres created_at y updated_at

    protected $fillable = [
        'placa',
        'modelo',
        'num_serie',
        'anio',
        'marca',
        'num_taxi',
        'foto_taxi',
    ];
}
