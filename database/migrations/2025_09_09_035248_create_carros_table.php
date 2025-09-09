<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('carros', function (Blueprint $table) {
        $table->increments('id_carro');
        $table->string('placa', 45);
        $table->string('modelo', 100);
        $table->string('num_serie', 400);
        $table->integer('anio');
        $table->string('marca', 45);
        $table->integer('num_taxi')->nullable();
        $table->string('foto_taxi', 255)->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carros');
    }
};
