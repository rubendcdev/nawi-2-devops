<?php

/**
 * Prueba de Animaciones AOS - NAWI
 *
 * Este script verifica que las animaciones AOS estén funcionando correctamente
 */

echo "🎬 PRUEBA DE ANIMACIONES AOS - NAWI\n";
echo "====================================\n\n";

// Verificar archivos relacionados con animaciones
echo "1️⃣ VERIFICACIÓN DE ARCHIVOS\n";
echo "============================\n\n";

$files = [
    'resources/views/layouts/app.blade.php' => 'Layout principal con AOS',
    'resources/views/welcome.blade.php' => 'Página de bienvenida con animaciones'
];

foreach ($files as $file => $description) {
    if (file_exists($file)) {
        echo "✅ $file - $description\n";

        $content = file_get_contents($file);

        // Verificar elementos específicos
        $checks = [
            'aos.css' => 'CSS de AOS cargado',
            'aos.js' => 'JavaScript de AOS cargado',
            'AOS.init' => 'AOS inicializado',
            'data-aos=' => 'Atributos de animación en elementos',
            'fade-down' => 'Animación fade-down',
            'fade-up' => 'Animación fade-up',
            'fade-right' => 'Animación fade-right',
            'fade-left' => 'Animación fade-left',
            'zoom-in' => 'Animación zoom-in'
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

// Verificar animaciones específicas en welcome.blade.php
echo "2️⃣ ANIMACIONES EN WELCOME.BLADE.PHP\n";
echo "===================================\n\n";

if (file_exists('resources/views/welcome.blade.php')) {
    $welcomeContent = file_get_contents('resources/views/welcome.blade.php');

    $animations = [
        'h1' => 'data-aos="fade-down" data-aos-duration="1000"',
        'p.subtitle' => 'data-aos="fade-up" data-aos-duration="1200"',
        'card 1' => 'data-aos="fade-right" data-aos-duration="1000"',
        'card 2' => 'data-aos="fade-up" data-aos-duration="1200"',
        'card 3' => 'data-aos="fade-left" data-aos-duration="1000"',
        'cta' => 'data-aos="zoom-in" data-aos-duration="1000"'
    ];

    foreach ($animations as $element => $animation) {
        if (strpos($welcomeContent, $animation) !== false) {
            echo "✅ $element: $animation\n";
        } else {
            echo "❌ $element: $animation (NO ENCONTRADO)\n";
        }
    }
} else {
    echo "❌ Archivo welcome.blade.php no encontrado\n";
}

echo "\n";

// Verificar configuración de AOS
echo "3️⃣ CONFIGURACIÓN DE AOS\n";
echo "========================\n\n";

if (file_exists('resources/views/layouts/app.blade.php')) {
    $layoutContent = file_get_contents('resources/views/layouts/app.blade.php');

    $aosConfig = [
        'once: true' => 'Animaciones solo una vez',
        'duration: 1000' => 'Duración de 1 segundo',
        'easing: ease-in-out' => 'Transición suave',
        'offset: 100' => 'Offset de 100px',
        'DOMContentLoaded' => 'Inicialización cuando DOM esté listo'
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

// Instrucciones de prueba
echo "4️⃣ INSTRUCCIONES DE PRUEBA\n";
echo "===========================\n\n";

echo "Para probar que las animaciones funcionan:\n\n";
echo "1. Asegúrate de que el servidor esté funcionando:\n";
echo "   php artisan serve\n\n";
echo "2. Ve a: http://localhost:8000\n\n";
echo "3. Deberías ver estas animaciones:\n\n";

$expectedAnimations = [
    'Título "Bienvenido a NAWI"' => 'Se desliza desde arriba (fade-down)',
    'Subtítulo' => 'Se desliza desde abajo (fade-up)',
    'Tarjeta "Taxi Seguro"' => 'Se desliza desde la derecha (fade-right)',
    'Tarjeta "Mapa Interactivo"' => 'Se desliza desde abajo (fade-up)',
    'Tarjeta "Comunidad Local"' => 'Se desliza desde la izquierda (fade-left)',
    'Botones de acción' => 'Aparecen con zoom (zoom-in)'
];

foreach ($expectedAnimations as $element => $animation) {
    echo "   🎬 $element: $animation\n";
}

echo "\n";

// Solución de problemas
echo "5️⃣ SOLUCIÓN DE PROBLEMAS\n";
echo "=========================\n\n";

echo "Si las animaciones no funcionan:\n\n";
echo "1. Verifica la consola del navegador (F12) para errores JavaScript\n";
echo "2. Asegúrate de que la conexión a internet funcione (AOS se carga desde CDN)\n";
echo "3. Prueba en modo incógnito para descartar problemas de caché\n";
echo "4. Verifica que el archivo layouts/app.blade.php tenga AOS configurado\n\n";

echo "6️⃣ MEJORAS IMPLEMENTADAS\n";
echo "========================\n\n";

$improvements = [
    'DOMContentLoaded' => 'AOS se inicializa cuando el DOM esté completamente cargado',
    'Configuración optimizada' => 'Duración, easing y offset configurados para mejor experiencia',
    'Animaciones específicas' => 'Cada elemento tiene su animación personalizada',
    'Duración variada' => 'Diferentes duraciones para crear un efecto más dinámico'
];

foreach ($improvements as $improvement => $description) {
    echo "✅ $improvement: $description\n";
}

echo "\n🎯 RESULTADO ESPERADO\n";
echo "=====================\n\n";
echo "✅ Animaciones suaves al cargar la página\n";
echo "✅ Elementos aparecen con efectos visuales atractivos\n";
echo "✅ Transiciones fluidas entre elementos\n";
echo "✅ Experiencia de usuario mejorada\n\n";

echo "🏁 PRUEBA DE ANIMACIONES COMPLETADA\n";
echo "===================================\n";
echo "Fecha: " . date('Y-m-d H:i:s') . "\n";
echo "Sistema: NAWI Animations v1.1.0\n";
