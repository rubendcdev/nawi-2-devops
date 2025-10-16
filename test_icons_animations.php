<?php

/**
 * Diagnóstico de Iconos y Animaciones - NAWI
 *
 * Este script diagnostica problemas con iconos y animaciones
 */

echo "🔍 DIAGNÓSTICO DE ICONOS Y ANIMACIONES - NAWI\n";
echo "=============================================\n\n";

// Verificar archivos
echo "1️⃣ VERIFICACIÓN DE ARCHIVOS\n";
echo "============================\n\n";

$files = [
    'resources/views/layouts/app.blade.php' => 'Layout principal',
    'resources/views/welcome.blade.php' => 'Página de bienvenida'
];

foreach ($files as $file => $description) {
    if (file_exists($file)) {
        echo "✅ $file - $description\n";

        $content = file_get_contents($file);

        // Verificar elementos específicos
        $checks = [
            'font-awesome' => 'FontAwesome cargado',
            'aos.css' => 'CSS de AOS cargado',
            'aos.js' => 'JavaScript de AOS cargado',
            'fas fa-taxi' => 'Icono de taxi',
            'fas fa-map-marked-alt' => 'Icono de mapa',
            'fas fa-users' => 'Icono de usuarios',
            'data-aos=' => 'Atributos de animación',
            'AOS.init' => 'AOS inicializado',
            'DOMContentLoaded' => 'Evento DOM cargado'
        ];

        foreach ($checks as $pattern => $description_check) {
            if (strpos($content, $pattern) !== false) {
                echo "   ✅ $description_check\n";
            } else {
                echo "   ❌ $description_check (NO ENCONTRADO)\n";
            }
        }
    } else {
        echo "❌ $file - $description (NO ENCONTRADO)\n";
    }
    echo "\n";
}

// Verificar iconos específicos en welcome.blade.php
echo "2️⃣ ICONOS EN WELCOME.BLADE.PHP\n";
echo "==============================\n\n";

if (file_exists('resources/views/welcome.blade.php')) {
    $welcomeContent = file_get_contents('resources/views/welcome.blade.php');

    $icons = [
        'fas fa-taxi' => 'Icono de taxi',
        'fas fa-map-marked-alt' => 'Icono de mapa',
        'fas fa-users' => 'Icono de usuarios',
        'fas fa-sign-in-alt' => 'Icono de login',
        'fas fa-user-plus' => 'Icono de registro'
    ];

    foreach ($icons as $icon => $description) {
        if (strpos($welcomeContent, $icon) !== false) {
            echo "✅ $description: $icon\n";
        } else {
            echo "❌ $description: $icon (NO ENCONTRADO)\n";
        }
    }
} else {
    echo "❌ Archivo welcome.blade.php no encontrado\n";
}

echo "\n";

// Verificar animaciones específicas
echo "3️⃣ ANIMACIONES EN WELCOME.BLADE.PHP\n";
echo "====================================\n\n";

if (file_exists('resources/views/welcome.blade.php')) {
    $welcomeContent = file_get_contents('resources/views/welcome.blade.php');

    $animations = [
        'data-aos="fade-down"' => 'Título fade-down',
        'data-aos="fade-up"' => 'Subtítulo fade-up',
        'data-aos="fade-right"' => 'Tarjeta 1 fade-right',
        'data-aos="fade-left"' => 'Tarjeta 3 fade-left',
        'data-aos="zoom-in"' => 'Botones zoom-in'
    ];

    foreach ($animations as $animation => $description) {
        if (strpos($welcomeContent, $animation) !== false) {
            echo "✅ $description: $animation\n";
        } else {
            echo "❌ $description: $animation (NO ENCONTRADO)\n";
        }
    }
} else {
    echo "❌ Archivo welcome.blade.php no encontrado\n";
}

echo "\n";

// Verificar configuración de AOS
echo "4️⃣ CONFIGURACIÓN DE AOS\n";
echo "========================\n\n";

if (file_exists('resources/views/layouts/app.blade.php')) {
    $layoutContent = file_get_contents('resources/views/layouts/app.blade.php');

    $aosConfig = [
        'AOS.init' => 'AOS inicializado',
        'once: true' => 'Animaciones solo una vez',
        'duration: 1000' => 'Duración de 1 segundo',
        'easing: ease-in-out' => 'Transición suave',
        'offset: 100' => 'Offset de 100px',
        'DOMContentLoaded' => 'Inicialización cuando DOM esté listo',
        'setTimeout' => 'Inicialización con delay',
        'console.log' => 'Logs de depuración'
    ];

    foreach ($aosConfig as $config => $description) {
        if (strpos($layoutContent, $config) !== false) {
            echo "✅ $description\n";
        } else {
            echo "❌ $description (NO ENCONTRADO)\n";
        }
    }
} else {
    echo "❌ Archivo layouts/app.blade.php no encontrado\n";
}

echo "\n";

// Instrucciones de diagnóstico
echo "5️⃣ INSTRUCCIONES DE DIAGNÓSTICO\n";
echo "================================\n\n";

echo "Para diagnosticar problemas:\n\n";
echo "1. Asegúrate de que el servidor esté funcionando:\n";
echo "   php artisan serve\n\n";
echo "2. Ve a: http://localhost:8000\n\n";
echo "3. Abre la consola del navegador (F12):\n";
echo "   • Deberías ver: 'AOS inicializado correctamente'\n";
echo "   • Deberías ver: 'FontAwesome cargado correctamente'\n";
echo "   • NO deberías ver errores de JavaScript\n\n";
echo "4. Verifica que los iconos se muestren:\n";
echo "   • Deberías ver iconos de taxi, mapa y usuarios\n";
echo "   • Los iconos deberían ser amarillos\n\n";
echo "5. Verifica que las animaciones funcionen:\n";
echo "   • Al cargar la página, los elementos deberían aparecer con animación\n";
echo "   • Al hacer scroll, los elementos deberían animarse\n\n";

// Solución de problemas
echo "6️⃣ SOLUCIÓN DE PROBLEMAS\n";
echo "========================\n\n";

$solutions = [
    'Iconos no aparecen' => [
        'Verificar conexión a internet',
        'Comprobar que FontAwesome se carga en la consola',
        'Verificar que no hay errores de CORS',
        'Probar con una versión local de FontAwesome'
    ],
    'Animaciones no funcionan' => [
        'Verificar que AOS se inicializa en la consola',
        'Comprobar que no hay errores de JavaScript',
        'Verificar que los atributos data-aos están presentes',
        'Probar con una versión local de AOS'
    ],
    'Elementos no se animan' => [
        'Verificar que los elementos tienen atributos data-aos',
        'Comprobar que AOS está configurado correctamente',
        'Verificar que no hay conflictos de CSS',
        'Probar con animaciones más simples'
    ]
];

foreach ($solutions as $problem => $solutions_list) {
    echo "🔧 $problem:\n";
    foreach ($solutions_list as $solution) {
        echo "   • $solution\n";
    }
    echo "\n";
}

// Código de prueba HTML
echo "7️⃣ CÓDIGO DE PRUEBA HTML\n";
echo "========================\n\n";

echo "Para probar si FontAwesome funciona, agrega esto temporalmente a welcome.blade.php:\n\n";
echo "<div style='position: fixed; top: 10px; right: 10px; background: red; color: white; padding: 10px; z-index: 9999;'>\n";
echo "  <i class='fas fa-taxi' style='font-size: 2rem; color: yellow;'></i>\n";
echo "  <i class='fas fa-map-marked-alt' style='font-size: 2rem; color: yellow;'></i>\n";
echo "  <i class='fas fa-users' style='font-size: 2rem; color: yellow;'></i>\n";
echo "</div>\n\n";

echo "Si ves los iconos amarillos en la esquina superior derecha, FontAwesome funciona.\n";
echo "Si no los ves, hay un problema con la carga de FontAwesome.\n\n";

echo "🎯 RESULTADO ESPERADO\n";
echo "=====================\n\n";
echo "✅ Iconos amarillos visibles en las tarjetas\n";
echo "✅ Animaciones suaves al cargar la página\n";
echo "✅ Elementos aparecen con efectos visuales\n";
echo "✅ Consola del navegador sin errores\n";
echo "✅ AOS y FontAwesome cargados correctamente\n\n";

echo "🏁 DIAGNÓSTICO COMPLETADO\n";
echo "=========================\n";
echo "Fecha: " . date('Y-m-d H:i:s') . "\n";
echo "Sistema: NAWI Icons & Animations Diagnostic v1.1.0\n";
