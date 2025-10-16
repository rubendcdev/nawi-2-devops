<?php

/**
 * Script Simple de Debug para Login - NAWI
 */

echo "🔍 DIAGNÓSTICO SIMPLE DE LOGIN - NAWI\n";
echo "=====================================\n\n";

// Verificar archivos clave
echo "1️⃣ VERIFICACIÓN DE ARCHIVOS\n";
echo "============================\n\n";

$files = [
    'app/Http/Controllers/WebAuthController.php',
    'resources/views/auth/login.blade.php',
    'routes/web.php',
    'app/Http/Kernel.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        echo "✅ $file\n";
    } else {
        echo "❌ $file (NO ENCONTRADO)\n";
    }
}

// Verificar contenido del controlador
echo "\n2️⃣ VERIFICACIÓN DEL CONTROLADOR\n";
echo "================================\n\n";

$controllerFile = 'app/Http/Controllers/WebAuthController.php';
if (file_exists($controllerFile)) {
    $content = file_get_contents($controllerFile);

    echo "Contenido del controlador:\n";
    echo "--------------------------\n";

    // Buscar líneas importantes
    $lines = explode("\n", $content);
    foreach ($lines as $num => $line) {
        if (strpos($line, 'back()->withErrors') !== false ||
            strpos($line, 'withInput') !== false ||
            strpos($line, 'validate(') !== false ||
            strpos($line, 'email.required') !== false) {
            echo "Línea " . ($num + 1) . ": " . trim($line) . "\n";
        }
    }
}

// Verificar contenido de la vista
echo "\n3️⃣ VERIFICACIÓN DE LA VISTA\n";
echo "============================\n\n";

$viewFile = 'resources/views/auth/login.blade.php';
if (file_exists($viewFile)) {
    $content = file_get_contents($viewFile);

    echo "Contenido de la vista:\n";
    echo "----------------------\n";

    // Buscar líneas importantes
    $lines = explode("\n", $content);
    foreach ($lines as $num => $line) {
        if (strpos($line, '@error(') !== false ||
            strpos($line, '$errors->any()') !== false ||
            strpos($line, 'invalid-feedback') !== false ||
            strpos($line, 'old(') !== false) {
            echo "Línea " . ($num + 1) . ": " . trim($line) . "\n";
        }
    }
}

// Simular validación
echo "\n4️⃣ SIMULACIÓN DE VALIDACIÓN\n";
echo "=============================\n\n";

$testData = [
    'email' => 'ooo',
    'password' => 'test123'
];

echo "Datos de prueba:\n";
echo "Email: '{$testData['email']}'\n";
echo "Password: '{$testData['password']}'\n\n";

// Simular validación
$errors = [];

if (empty($testData['email'])) {
    $errors[] = 'El email es obligatorio';
} elseif (!filter_var($testData['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'El formato del email no es válido';
}

if (empty($testData['password'])) {
    $errors[] = 'La contraseña es obligatoria';
}

if (!empty($errors)) {
    echo "❌ Errores detectados:\n";
    foreach ($errors as $error) {
        echo "   • $error\n";
    }
    echo "\n✅ Estos errores DEBERÍAN mostrarse en la vista\n";
} else {
    echo "✅ Datos válidos - No hay errores\n";
}

// Comandos de solución
echo "\n5️⃣ COMANDOS DE SOLUCIÓN\n";
echo "========================\n\n";

echo "Si los errores no se muestran, ejecuta estos comandos:\n\n";
echo "1. Limpiar caché de vistas:\n";
echo "   php artisan view:clear\n\n";
echo "2. Limpiar caché de configuración:\n";
echo "   php artisan config:clear\n\n";
echo "3. Limpiar caché de rutas:\n";
echo "   php artisan route:clear\n\n";
echo "4. Verificar que el servidor esté funcionando:\n";
echo "   php artisan serve\n\n";

// Instrucciones de prueba
echo "6️⃣ INSTRUCCIONES DE PRUEBA\n";
echo "===========================\n\n";

echo "Para probar el login:\n\n";
echo "1. Asegúrate de que el servidor esté funcionando:\n";
echo "   php artisan serve\n\n";
echo "2. Ve a: http://localhost:8000/login\n\n";
echo "3. Prueba estos casos:\n";
echo "   • Deja el email vacío → Debería mostrar: 'El email es obligatorio'\n";
echo "   • Ingresa 'ooo' en email → Debería mostrar: 'El formato del email no es válido'\n";
echo "   • Deja la contraseña vacía → Debería mostrar: 'La contraseña es obligatoria'\n\n";

echo "Si NO ves los errores:\n";
echo "• Verifica que el servidor esté funcionando\n";
echo "• Verifica que las rutas estén configuradas correctamente\n";
echo "• Revisa los logs en storage/logs/laravel.log\n";
echo "• Verifica que el middleware ShareErrorsFromSession esté funcionando\n\n";

echo "🏁 DIAGNÓSTICO COMPLETADO\n";
echo "==========================\n";
echo "Fecha: " . date('Y-m-d H:i:s') . "\n";
