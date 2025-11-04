<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idioma extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_dioma';
    protected $fillable = ['tipo'];

    public function pasajeros()
    {
        return $this->hasMany(Pasajero::class, 'id_dioma');
    }
}
