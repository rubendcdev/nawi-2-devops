<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pasajeros', function (Blueprint $table) {
            $table->id('id_pasajero');
            $table->string('nombre', 100)->nullable();
            $table->string('apellidos', 100)->nullable();
            $table->string('ine', 255)->nullable();
            $table->string('foto', 255)->nullable();
            $table->string('correo', 105)->nullable();
            $table->string('num_telefono', 20)->nullable();
            $table->string('contrasena', 10)->nullable();
            $table->boolean('discapacidad')->nullable();
            $table->unsignedBigInteger('id_genero');
            $table->unsignedBigInteger('id_dioma');
            $table->timestamps();

            // Claves foráneas
            $table->foreign('id_genero')->references('id_genero')->on('generos');
            $table->foreign('id_dioma')->references('id_dioma')->on('idiomas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasajeros');
    }
};
