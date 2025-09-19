<?php

namespace App\Models;

use App\Http\Controllers\TaxistaController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxi extends Model
{
    use HasFactory;

    protected $fillable = ['placa', 'modelo', 'color'];

    public function taxistas()
    {
        return $this->hasMany(TaxistaController::class);
    }
}
