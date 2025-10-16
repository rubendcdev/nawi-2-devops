// Script para manejar la instalación de PWA
let deferredPrompt;

// Detectar cuando el navegador puede instalar la PWA
window.addEventListener('beforeinstallprompt', (e) => {
    // Prevenir que el navegador muestre automáticamente el prompt
    e.preventDefault();
    // Guardar el evento para usarlo más tarde
    deferredPrompt = e;

    // Mostrar botón de instalación personalizado
    showInstallButton();
});

// Función para mostrar el botón de instalación
function showInstallButton() {
    // Crear botón de instalación si no existe
    if (!document.getElementById('install-pwa-btn')) {
        const installBtn = document.createElement('button');
        installBtn.id = 'install-pwa-btn';
        installBtn.innerHTML = '<i class="fas fa-download"></i> Instalar NAWI';
        installBtn.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: linear-gradient(45deg, #ffc107, #ff9800);
            color: #000;
            border: none;
            padding: 12px 20px;
            border-radius: 25px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.4);
            z-index: 1000;
            transition: all 0.3s ease;
        `;

        installBtn.addEventListener('click', installPWA);
        document.body.appendChild(installBtn);
    }
}

// Función para instalar la PWA
function installPWA() {
    if (deferredPrompt) {
        // Mostrar el prompt de instalación
        deferredPrompt.prompt();

        // Esperar a que el usuario responda
        deferredPrompt.userChoice.then((choiceResult) => {
            if (choiceResult.outcome === 'accepted') {
                console.log('Usuario aceptó instalar la PWA');
            } else {
                console.log('Usuario rechazó instalar la PWA');
            }
            // Limpiar el prompt guardado
            deferredPrompt = null;
            // Ocultar el botón
            const installBtn = document.getElementById('install-pwa-btn');
            if (installBtn) {
                installBtn.remove();
            }
        });
    }
}

// Detectar si la app ya está instalada
window.addEventListener('appinstalled', (evt) => {
    console.log('PWA instalada exitosamente');
    // Ocultar el botón de instalación
    const installBtn = document.getElementById('install-pwa-btn');
    if (installBtn) {
        installBtn.remove();
    }
});

// Detectar si la app se está ejecutando en modo standalone
if (window.matchMedia('(display-mode: standalone)').matches) {
    console.log('La app se está ejecutando en modo standalone');
    // Ocultar el botón de instalación si ya está instalada
    const installBtn = document.getElementById('install-pwa-btn');
    if (installBtn) {
        installBtn.remove();
    }
}

