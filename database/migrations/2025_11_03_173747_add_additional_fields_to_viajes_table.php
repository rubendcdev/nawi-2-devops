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
        // Renombrar columnas usando DB raw para mayor compatibilidad
        if (Schema::hasColumn('viajes', 'lat_salida')) {
            DB::statement('ALTER TABLE viajes CHANGE lat_salida latitud_origen DOUBLE');
        }
        if (Schema::hasColumn('viajes', 'lon_salida')) {
            DB::statement('ALTER TABLE viajes CHANGE lon_salida longitud_origen DOUBLE');
        }
        if (Schema::hasColumn('viajes', 'lat_destino')) {
            DB::statement('ALTER TABLE viajes CHANGE lat_destino latitud_destino DOUBLE');
        }
        if (Schema::hasColumn('viajes', 'lon_destino')) {
            DB::statement('ALTER TABLE viajes CHANGE lon_destino longitud_destino DOUBLE');
        }

        Schema::table('viajes', function (Blueprint $table) {
            // Agregar id_taxista directo (opcional)
            if (!Schema::hasColumn('viajes', 'id_taxista')) {
                $table->char('id_taxista', 36)->nullable()->after('id_pasajero');
            }
        });

        // Agregar índice y foreign key para id_taxista
        if (Schema::hasColumn('viajes', 'id_taxista')) {
            try {
                Schema::table('viajes', function (Blueprint $table) {
                    $table->index('id_taxista', 'viaje_taxista_idx');
                });
            } catch (\Exception $e) {
                // El índice ya existe, ignorar
            }

            // Foreign key solo si no existe
            try {
                DB::statement('ALTER TABLE viajes ADD CONSTRAINT viaje_taxista_fk FOREIGN KEY (id_taxista) REFERENCES taxistas(id) ON DELETE SET NULL');
            } catch (\Exception $e) {
                // La foreign key ya existe, ignorar
            }
        }

        Schema::table('viajes', function (Blueprint $table) {
            // Agregar direcciones
            if (!Schema::hasColumn('viajes', 'direccion_origen')) {
                $table->string('direccion_origen', 255)->nullable()->after('longitud_origen');
            }
            if (!Schema::hasColumn('viajes', 'direccion_destino')) {
                $table->string('direccion_destino', 255)->nullable()->after('longitud_destino');
            }

            // Agregar fechas de aceptación y completado
            if (!Schema::hasColumn('viajes', 'fecha_aceptacion')) {
                $table->timestamp('fecha_aceptacion')->nullable()->after('estado');
            }
            if (!Schema::hasColumn('viajes', 'fecha_completado')) {
                $table->timestamp('fecha_completado')->nullable()->after('fecha_aceptacion');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('viajes', function (Blueprint $table) {
            // Eliminar id_taxista (primero foreign key e índice)
            if (Schema::hasColumn('viajes', 'id_taxista')) {
                try {
                    DB::statement('ALTER TABLE viajes DROP FOREIGN KEY viaje_taxista_fk');
                } catch (\Exception $e) {
                    // Ignorar si no existe
                }
                try {
                    $table->dropIndex('viaje_taxista_idx');
                } catch (\Exception $e) {
                    // Ignorar si no existe
                }
                $table->dropColumn('id_taxista');
            }

            // Eliminar direcciones
            if (Schema::hasColumn('viajes', 'direccion_origen')) {
                $table->dropColumn('direccion_origen');
            }
            if (Schema::hasColumn('viajes', 'direccion_destino')) {
                $table->dropColumn('direccion_destino');
            }

            // Eliminar fechas
            if (Schema::hasColumn('viajes', 'fecha_aceptacion')) {
                $table->dropColumn('fecha_aceptacion');
            }
            if (Schema::hasColumn('viajes', 'fecha_completado')) {
                $table->dropColumn('fecha_completado');
            }
        });

        // Revertir renombres usando DB raw
        if (Schema::hasColumn('viajes', 'latitud_origen')) {
            DB::statement('ALTER TABLE viajes CHANGE latitud_origen lat_salida DOUBLE');
        }
        if (Schema::hasColumn('viajes', 'longitud_origen')) {
            DB::statement('ALTER TABLE viajes CHANGE longitud_origen lon_salida DOUBLE');
        }
        if (Schema::hasColumn('viajes', 'latitud_destino')) {
            DB::statement('ALTER TABLE viajes CHANGE latitud_destino lat_destino DOUBLE');
        }
        if (Schema::hasColumn('viajes', 'longitud_destino')) {
            DB::statement('ALTER TABLE viajes CHANGE longitud_destino lon_destino DOUBLE');
        }
    }
};
