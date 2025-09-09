<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\CarroController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

        Route::resource('carros', CarroController::class);
        Route::get('/perfil', [PerfilController::class, 'show'])->name('perfil.show');
        Route::get('/perfil/editar', [PerfilController::class, 'edit'])->name('perfil.edit');
        Route::put('/perfil', [PerfilController::class, 'update'])->name('perfil.update');
        Route::resource('vehiculos', VehiculoController::class)->middleware('auth');
    Route::get('/datos-personales', function () {
        $user = Auth::user();
        return view('perfil.datos', compact('user'));
    })->middleware('auth')->name('datos-personales');

});
