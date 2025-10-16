<?php

/**
 * Script de Debug para Login - NAWI
 *
 * Este script ayuda a diagnosticar por qué no se muestran los errores
 */

echo "🔍 DIAGNÓSTICO DE ERRORES DE LOGIN - NAWI\n";
echo "==========================================\n\n";

// Verificar configuración de Laravel
echo "1️⃣ VERIFICACIÓN DE CONFIGURACIÓN\n";
echo "==================================\n\n";

// Verificar si existe el archivo .env
if (file_exists('.env')) {
    echo "✅ Archivo .env encontrado\n";
} else {
    echo "❌ Archivo .env NO encontrado\n";
}

// Verificar configuración de sesiones
echo "\n2️⃣ CONFIGURACIÓN DE SESIONES\n";
echo "=============================\n";

$sessionConfig = [
    'APP_DEBUG' => env('APP_DEBUG', 'false'),
    'SESSION_DRIVER' => env('SESSION_DRIVER', 'file'),
    'SESSION_LIFETIME' => env('SESSION_LIFETIME', '120'),
];

foreach ($sessionConfig as $key => $value) {
    echo "$key: $value\n";
}

// Verificar middleware
echo "\n3️⃣ MIDDLEWARE CONFIGURADO\n";
echo "===========================\n";

$middlewareGroups = [
    'web' => [
        'EncryptCookies',
        'AddQueuedCookiesToResponse',
        'StartSession',
        'ShareErrorsFromSession', // Este es crucial para mostrar errores
        'VerifyCsrfToken',
        'SubstituteBindings'
    ]
];

echo "Middleware del grupo 'web':\n";
foreach ($middlewareGroups['web'] as $middleware) {
    echo "  • $middleware\n";
}

// Simular flujo de validación
echo "\n4️⃣ SIMULACIÓN DE FLUJO DE VALIDACIÓN\n";
echo "=====================================\n\n";

$testCases = [
    'email_vacio' => [
        'email' => '',
        'password' => 'test123',
        'expected_behavior' => 'Mostrar error: "El email es obligatorio"'
    ],
    'email_invalido' => [
        'email' => 'ooo',
        'password' => 'test123',
        'expected_behavior' => 'Mostrar error: "El formato del email no es válido"'
    ],
    'password_vacio' => [
        'email' => 'test@example.com',
        'password' => '',
        'expected_behavior' => 'Mostrar error: "La contraseña es obligatoria"'
    ]
];

foreach ($testCases as $caso => $data) {
    echo "🔍 Probando: " . strtoupper(str_replace('_', ' ', $caso)) . "\n";
    echo "Email: '{$data['email']}'\n";
    echo "Password: '{$data['password']}'\n";
    echo "Comportamiento esperado: {$data['expected_behavior']}\n";

    // Simular validación
    $errors = [];

    if (empty($data['email'])) {
        $errors[] = 'El email es obligatorio';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'El formato del email no es válido';
    }

    if (empty($data['password'])) {
        $errors[] = 'La contraseña es obligatoria';
    }

    if (!empty($errors)) {
        echo "❌ Errores detectados:\n";
        foreach ($errors as $error) {
            echo "   • $error\n";
        }
        echo "✅ Los errores DEBERÍAN mostrarse en la vista\n";
    } else {
        echo "✅ Datos válidos - No hay errores\n";
    }
    echo "\n";
}

// Verificar archivos clave
echo "5️⃣ VERIFICACIÓN DE ARCHIVOS CLAVE\n";
echo "==================================\n\n";

$keyFiles = [
    'app/Http/Controllers/WebAuthController.php' => 'Controlador de login',
    'resources/views/auth/login.blade.php' => 'Vista de login',
    'routes/web.php' => 'Rutas web',
    'app/Http/Kernel.php' => 'Configuración de middleware'
];

foreach ($keyFiles as $file => $description) {
    if (file_exists($file)) {
        echo "✅ $file - $description\n";
    } else {
        echo "❌ $file - $description (NO ENCONTRADO)\n";
    }
}

// Verificar contenido del controlador
echo "\n6️⃣ VERIFICACIÓN DEL CONTROLADOR\n";
echo "================================\n\n";

$controllerFile = 'app/Http/Controllers/WebAuthController.php';
if (file_exists($controllerFile)) {
    $content = file_get_contents($controllerFile);

    $checks = [
        'back()->withErrors' => 'Manejo correcto de errores',
        'withInput' => 'Persistencia de datos del formulario',
        'validate(' => 'Validación de datos',
        'email.required' => 'Mensajes de error personalizados',
        'email.email' => 'Validación de formato de email'
    ];

    foreach ($checks as $pattern => $description) {
        if (strpos($content, $pattern) !== false) {
            echo "✅ $description\n";
        } else {
            echo "❌ $description (NO ENCONTRADO)\n";
        }
    }
}

// Verificar contenido de la vista
echo "\n7️⃣ VERIFICACIÓN DE LA VISTA\n";
echo "============================\n\n";

$viewFile = 'resources/views/auth/login.blade.php';
if (file_exists($viewFile)) {
    $content = file_get_contents($viewFile);

    $checks = [
        '@error(' => 'Directiva @error para mostrar errores',
        '$errors->any()' => 'Verificación de errores',
        'invalid-feedback' => 'Clases CSS para errores',
        'old(' => 'Persistencia de datos del formulario',
        'placeholder=' => 'Placeholders en campos'
    ];

    foreach ($checks as $pattern => $description) {
        if (strpos($content, $pattern) !== false) {
            echo "✅ $description\n";
        } else {
            echo "❌ $description (NO ENCONTRADO)\n";
        }
    }
}

// Posibles problemas y soluciones
echo "\n8️⃣ POSIBLES PROBLEMAS Y SOLUCIONES\n";
echo "====================================\n\n";

$problems = [
    'Middleware de sanitización' => [
        'Problema' => 'El middleware InputSanitizationMiddleware puede estar interfiriendo',
        'Solución' => 'Verificar que no esté causando problemas con la validación'
    ],
    'Configuración de sesiones' => [
        'Problema' => 'Las sesiones no están funcionando correctamente',
        'Solución' => 'Verificar SESSION_DRIVER y permisos de storage'
    ],
    'Middleware ShareErrorsFromSession' => [
        'Problema' => 'El middleware no está compartiendo errores con la vista',
        'Solución' => 'Verificar que esté en el grupo middleware web'
    ],
    'Cache de vistas' => [
        'Problema' => 'Las vistas están cacheadas y no reflejan cambios',
        'Solución' => 'Ejecutar: php artisan view:clear'
    ]
];

foreach ($problems as $titulo => $info) {
    echo "🔧 $titulo:\n";
    echo "   Problema: {$info['Problema']}\n";
    echo "   Solución: {$info['Solución']}\n\n";
}

// Comandos de diagnóstico
echo "9️⃣ COMANDOS DE DIAGNÓSTICO\n";
echo "===========================\n\n";

echo "Para diagnosticar el problema, ejecuta estos comandos:\n\n";
echo "1. Limpiar caché de vistas:\n";
echo "   php artisan view:clear\n\n";
echo "2. Limpiar caché de configuración:\n";
echo "   php artisan config:clear\n\n";
echo "3. Verificar rutas:\n";
echo "   php artisan route:list\n\n";
echo "4. Verificar middleware:\n";
echo "   php artisan route:list --middleware=web\n\n";

// Instrucciones de prueba
echo "🔟 INSTRUCCIONES DE PRUEBA\n";
echo "===========================\n\n";

echo "Para probar si los errores se muestran:\n\n";
echo "1. Ve a: http://localhost:8000/login\n";
echo "2. Deja el campo email vacío\n";
echo "3. Haz clic en 'Iniciar Sesión'\n";
echo "4. Deberías ver: 'El email es obligatorio'\n\n";

echo "Si NO ves el error:\n";
echo "• Verifica que el servidor esté funcionando\n";
echo "• Verifica que las rutas estén configuradas\n";
echo "• Verifica que el middleware esté funcionando\n";
echo "• Revisa los logs en storage/logs/laravel.log\n\n";

echo "🏁 DIAGNÓSTICO COMPLETADO\n";
echo "==========================\n";
echo "Fecha: " . date('Y-m-d H:i:s') . "\n";
echo "Sistema: NAWI Login Debug v1.1.0\n";
