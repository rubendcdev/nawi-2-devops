<?php

use App\Http\Controllers\PaginaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\TaxistaController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/perfil', [PerfilController::class, 'show'])->name('perfil.show');
Route::post('/perfil', [PerfilController::class, 'update'])->name('perfil.update');


Route::middleware(['auth'])->group(function () {
    Route::get('/perfil', [PerfilController::class, 'show'])->name('perfil.show');
    Route::get('/perfil/editar', [PerfilController::class, 'edit'])->name('perfil.edit');
    Route::put('/perfil/actualizar', [PerfilController::class, 'update'])->name('perfil.update');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/taxistas', [TaxistaController::class, 'index'])->name('taxistas.index');
Route::get('/sobre-nosotros', [PaginaController::class, 'sobreNosotros'])->name('sobre-nosotros');

