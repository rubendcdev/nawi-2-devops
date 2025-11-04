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
        Schema::table('viajes', function (Blueprint $table) {
            $table->enum('estado', ['pendiente', 'aceptado', 'en_curso', 'completado', 'cancelado'])
                  ->default('pendiente')
                  ->after('id_pasajero');
            $table->text('comentario')->nullable()->after('estado');
            $table->double('lat_actual')->nullable()->after('comentario');
            $table->double('lon_actual')->nullable()->after('lat_actual');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('viajes', function (Blueprint $table) {
            $table->dropColumn(['estado', 'comentario', 'lat_actual', 'lon_actual']);
        });
    }
};
