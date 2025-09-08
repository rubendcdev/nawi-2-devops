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
    Schema::table('users', function (Blueprint $table) {
        $table->string('telefono')->nullable();
        $table->string('direccion')->nullable();
        $table->string('licencia')->nullable();
        $table->string('tarjeta_circulacion')->nullable();
        $table->boolean('activo')->default(false); // Activación pendiente
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['telefono', 'direccion', 'licencia', 'tarjeta_circulacion', 'activo']);
    });
}

};