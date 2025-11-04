<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Actualizar valores existentes antes de cambiar el enum
        DB::statement("UPDATE viajes SET estado = 'solicitado' WHERE estado = 'pendiente'");
        DB::statement("UPDATE viajes SET estado = 'en_progreso' WHERE estado = 'en_curso'");

        // Modificar el enum para incluir los nuevos valores
        DB::statement("ALTER TABLE viajes MODIFY COLUMN estado ENUM('solicitado', 'aceptado', 'en_progreso', 'completado', 'cancelado', 'rechazado') DEFAULT 'solicitado'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir valores
        DB::statement("UPDATE viajes SET estado = 'pendiente' WHERE estado = 'solicitado'");
        DB::statement("UPDATE viajes SET estado = 'en_curso' WHERE estado = 'en_progreso'");
        DB::statement("UPDATE viajes SET estado = 'cancelado' WHERE estado = 'rechazado'");

        // Revertir el enum
        DB::statement("ALTER TABLE viajes MODIFY COLUMN estado ENUM('pendiente', 'aceptado', 'en_curso', 'completado', 'cancelado') DEFAULT 'pendiente'");
    }
};
