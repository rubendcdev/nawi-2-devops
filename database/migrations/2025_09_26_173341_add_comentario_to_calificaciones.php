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
        Schema::table('calificacion_viajes', function (Blueprint $table) {
            $table->text('comentario')->nullable()->after('id_viaje');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calificacion_viajes', function (Blueprint $table) {
            $table->dropColumn('comentario');
        });
    }
};
