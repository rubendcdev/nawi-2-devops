<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeneroController;
use App\Http\Controllers\IdiomaController;
use App\Http\Controllers\PasajeroController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas para Géneros
Route::apiResource('generos', GeneroController::class);

// Rutas para Idiomas
Route::apiResource('idiomas', IdiomaController::class);

// Rutas para Pasajeros
Route::apiResource('pasajeros', PasajeroController::class);
