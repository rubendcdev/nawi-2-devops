<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\RoleService;
use App\Services\EstatusDocumentoService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Crear roles básicos automáticamente si no existen
        try {
            $roleService = app(RoleService::class);
            $roleService->ensureDefaultRoles();
        } catch (\Exception $e) {
            // Ignorar errores durante el bootstrap (por ejemplo, si la tabla no existe aún)
        }

        // Crear estatus de documentos básicos automáticamente si no existen
        try {
            $estatusService = app(EstatusDocumentoService::class);
            $estatusService->ensureDefaultEstatus();
        } catch (\Exception $e) {
            // Ignorar errores durante el bootstrap (por ejemplo, si la tabla no existe aún)
        }
    }
}
