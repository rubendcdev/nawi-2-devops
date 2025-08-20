<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('taxistas', function (Blueprint $table) {
            $table->id('id_taxista');
            $table->string('nombre', 100);
            $table->string('apellidos', 100);
            $table->integer('edad')->nullable();
            $table->string('ine')->nullable();
            $table->string('permiso')->nullable();
            $table->string('licencia')->nullable();
            $table->string('num_telefono', 20);
            $table->string('contrasena');
            $table->string('foto_conductor')->nullable();
            $table->string('foto_taxi')->nullable();
            $table->string('ubicacion_actual')->nullable();
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->enum('turno', ['mañana', 'tarde', 'noche'])->nullable();
            $table->unsignedBigInteger('id_carro')->nullable();
            $table->unsignedBigInteger('id_genero')->nullable();
            $table->unsignedBigInteger('id_idioma')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('taxistas');
    }
};

