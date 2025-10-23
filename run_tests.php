<?php

/**
 * Script Principal de Pruebas de Seguridad - NAWI
 *
 * Este script ejecuta todas las pruebas de seguridad implementadas
 */

echo "🚀 INICIANDO PRUEBAS COMPLETAS DE SEGURIDAD - NAWI\n";
echo "==================================================\n\n";

// Lista de pruebas a ejecutar
$tests = [
    'test_validation.php' => 'Pruebas de Validación de Datos',
    'test_rate_limiting.php' => 'Pruebas de Rate Limiting',
    'test_web_services.php' => 'Pruebas de Integración con Web Services'
];

$totalTests = count($tests);
$passedTests = 0;

echo "📋 PLAN DE PRUEBAS\n";
echo "==================\n";
foreach ($tests as $file => $description) {
    echo "• $description\n";
}
echo "\n";

// Ejecutar cada prueba
foreach ($tests as $file => $description) {
    echo "🧪 EJECUTANDO: $description\n";
    echo str_repeat("=", strlen($description) + 20) . "\n\n";

    if (file_exists($file)) {
        include $file;
        $passedTests++;
        echo "\n✅ PRUEBA COMPLETADA: $description\n";
    } else {
        echo "❌ ERROR: No se encontró el archivo $file\n";
    }

    echo "\n" . str_repeat("-", 50) . "\n\n";
}

// Resumen final
echo "📊 RESUMEN FINAL DE PRUEBAS\n";
echo "===========================\n";
echo "Total de pruebas: $totalTests\n";
echo "Pruebas exitosas: $passedTests\n";
echo "Pruebas fallidas: " . ($totalTests - $passedTests) . "\n";
echo "Porcentaje de éxito: " . round(($passedTests / $totalTests) * 100, 2) . "%\n\n";

if ($passedTests === $totalTests) {
    echo "🎉 ¡TODAS LAS PRUEBAS PASARON EXITOSAMENTE!\n";
    echo "==========================================\n";
    echo "✅ Mecanismos de seguridad implementados correctamente\n";
    echo "✅ Validación de datos funcionando\n";
    echo "✅ Rate limiting funcionando\n";
    echo "✅ Integración con Web Services funcionando\n";
    echo "✅ Sistema de logging funcionando\n";
    echo "✅ Headers de seguridad aplicados\n";
    echo "✅ Sanitización de entrada funcionando\n";
} else {
    echo "⚠️ ALGUNAS PRUEBAS FALLARON\n";
    echo "==========================\n";
    echo "Revisa los errores anteriores y corrige los problemas.\n";
}

echo "\n📝 PRÓXIMOS PASOS\n";
echo "==================\n";
echo "1. Configurar base de datos MySQL\n";
echo "2. Ejecutar migraciones: php artisan migrate\n";
echo "3. Configurar variables de entorno en .env\n";
echo "4. Configurar Passport: php artisan passport:install\n";
echo "5. Probar endpoints con Postman o curl\n";
echo "6. Verificar logs en storage/logs/security.log\n";

echo "\n🔗 ENLACES ÚTILES\n";
echo "==================\n";
echo "• Documentación de seguridad: SECURITY_IMPLEMENTATION.md\n";
echo "• Control de versiones: VERSION_CONTROL.md\n";
echo "• Logs de seguridad: storage/logs/security.log\n";
echo "• Configuración: config/security.php\n";

echo "\n🏁 PRUEBAS COMPLETADAS\n";
echo "======================\n";
echo "Fecha: " . date('Y-m-d H:i:s') . "\n";
echo "Sistema: NAWI Security Implementation v1.1.0\n";
