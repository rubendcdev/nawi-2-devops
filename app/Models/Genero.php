<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_genero';
    protected $fillable = ['tipo'];

    public function pasajeros()
    {
        return $this->hasMany(Pasajero::class, 'id_genero');
    }
}
