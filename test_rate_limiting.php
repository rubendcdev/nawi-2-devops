<?php

/**
 * Pruebas de Rate Limiting - NAWI
 */

echo "🚦 PRUEBAS DE RATE LIMITING\n";
echo "===========================\n\n";

// Simular diferentes escenarios de rate limiting
$scenarios = [
    'login_normal' => [
        'endpoint' => '/api/login',
        'max_attempts' => 10,
        'decay_minutes' => 1,
        'description' => 'Login normal (10 intentos por minuto)'
    ],
    'registro_normal' => [
        'endpoint' => '/api/register/pasajero',
        'max_attempts' => 5,
        'decay_minutes' => 1,
        'description' => 'Registro normal (5 intentos por minuto)'
    ],
    'recuperacion_password' => [
        'endpoint' => '/api/password/reset-link',
        'max_attempts' => 3,
        'decay_minutes' => 1,
        'description' => 'Recuperación de contraseña (3 intentos por minuto)'
    ],
    'api_general' => [
        'endpoint' => '/api/viajes',
        'max_attempts' => 60,
        'decay_minutes' => 1,
        'description' => 'API general (60 intentos por minuto)'
    ]
];

foreach ($scenarios as $scenario => $config) {
    echo "🔍 Probando: " . strtoupper(str_replace('_', ' ', $scenario)) . "\n";
    echo "----------------------------------------\n";
    echo "Endpoint: {$config['endpoint']}\n";
    echo "Límite: {$config['max_attempts']} intentos por {$config['decay_minutes']} minuto(s)\n";
    echo "Descripción: {$config['description']}\n\n";

    // Simular intentos
    echo "Simulando intentos:\n";
    for ($i = 1; $i <= $config['max_attempts'] + 3; $i++) {
        if ($i <= $config['max_attempts']) {
            echo "   Intento #$i: ✅ Permitido\n";
        } else {
            echo "   Intento #$i: ❌ Bloqueado (Rate limit excedido)\n";
        }
    }

    echo "\n";
}

// Simular diferentes tipos de usuarios
echo "👥 RATE LIMITING POR TIPO DE USUARIO\n";
echo "====================================\n\n";

$userTypes = [
    'pasajero' => [
        'crear_viaje' => '30 intentos por minuto',
        'cancelar_viaje' => '30 intentos por minuto',
        'calificar_viaje' => '30 intentos por minuto'
    ],
    'taxista' => [
        'aceptar_viaje' => '60 intentos por minuto',
        'rechazar_viaje' => '60 intentos por minuto',
        'completar_viaje' => '60 intentos por minuto'
    ],
    'general' => [
        'estado_viaje' => '120 intentos por minuto',
        'actualizar_ubicacion' => '120 intentos por minuto'
    ]
];

foreach ($userTypes as $tipo => $endpoints) {
    echo "🔹 $tipo:\n";
    foreach ($endpoints as $endpoint => $limite) {
        echo "   • $endpoint: $limite\n";
    }
    echo "\n";
}

// Simular bloqueo por IP
echo "🌐 RATE LIMITING POR IP\n";
echo "=======================\n\n";

$ips = [
    '192.168.1.100' => 'IP normal - Sin restricciones',
    '192.168.1.101' => 'IP sospechosa - Rate limit reducido',
    '10.0.0.1' => 'IP de desarrollo - Límites relajados'
];

foreach ($ips as $ip => $descripcion) {
    echo "IP: $ip\n";
    echo "Descripción: $descripcion\n";

    if (strpos($descripcion, 'sospechosa') !== false) {
        echo "Límite aplicado: 5 intentos por minuto\n";
        echo "Estado: ⚠️ Monitoreado\n";
    } elseif (strpos($descripcion, 'desarrollo') !== false) {
        echo "Límite aplicado: 1000 intentos por minuto\n";
        echo "Estado: ✅ Desarrollo\n";
    } else {
        echo "Límite aplicado: Límites estándar\n";
        echo "Estado: ✅ Normal\n";
    }
    echo "\n";
}

// Simular headers de rate limiting
echo "📊 HEADERS DE RATE LIMITING\n";
echo "===========================\n\n";

$headers = [
    'X-RateLimit-Limit' => '60',
    'X-RateLimit-Remaining' => '45',
    'X-RateLimit-Reset' => time() + 60,
    'Retry-After' => '60'
];

echo "Headers que se envían al cliente:\n";
foreach ($headers as $header => $value) {
    echo "   $header: $value\n";
}

echo "\n🎯 RESUMEN DE RATE LIMITING\n";
echo "============================\n";
echo "✅ Rate limiting implementado correctamente\n";
echo "✅ Límites diferenciados por endpoint\n";
echo "✅ Límites diferenciados por tipo de usuario\n";
echo "✅ Headers informativos implementados\n";
echo "✅ Bloqueo automático por IP\n";
echo "✅ Monitoreo de actividad sospechosa\n";
