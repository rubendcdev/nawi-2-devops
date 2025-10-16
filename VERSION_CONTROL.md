# Sistema de Control de Versiones - NAWI

## Repositorio
- **URL del repositorio**: https://github.com/tu-usuario/nawi-2
- **Plataforma**: GitHub
- **Tipo**: Repositorio privado

## Plan de Entregas (Release Plan)

### Versión 1.0.0 - MVP (Producto Mínimo Viable)
- **Fecha de lanzamiento**: 2024-10-15
- **Etiqueta**: `v1.0.0`
- **Descripción**: Versión inicial con funcionalidades básicas
- **Características**:
  - Registro de usuarios (pasajeros y taxistas)
  - Autenticación con Laravel Passport
  - Sistema básico de viajes
  - Validación de datos de entrada

### Versión 1.1.0 - Seguridad Avanzada
- **Fecha de lanzamiento**: 2024-10-30
- **Etiqueta**: `v1.1.0`
- **Descripción**: Implementación de mecanismos de seguridad robustos
- **Características**:
  - Middlewares de seguridad (headers, sanitización)
  - Rate limiting avanzado
  - Sistema de recuperación de contraseñas
  - Validación robusta de datos
  - Protección contra inyección SQL

### Versión 1.2.0 - Integración de Servicios
- **Fecha de lanzamiento**: 2024-11-15
- **Etiqueta**: `v1.2.0`
- **Descripción**: Integración con servicios externos
- **Características**:
  - Integración con Google Maps API
  - Sistema de pagos con Stripe
  - Servicios de geolocalización
  - APIs externas

### Versión 1.3.0 - Optimización y Monitoreo
- **Fecha de lanzamiento**: 2024-12-01
- **Etiqueta**: `v1.3.0`
- **Descripción**: Optimización de rendimiento y monitoreo
- **Características**:
  - Caché de respuestas
  - Logging avanzado
  - Monitoreo de rendimiento
  - Optimización de consultas

## Comandos de Git para Etiquetado

### Crear una nueva etiqueta
```bash
# Crear etiqueta anotada
git tag -a v1.0.0 -m "Versión 1.0.0 - MVP"

# Crear etiqueta ligera
git tag v1.0.0

# Subir etiquetas al repositorio remoto
git push origin v1.0.0

# Subir todas las etiquetas
git push origin --tags
```

### Listar etiquetas
```bash
# Listar todas las etiquetas
git tag

# Listar etiquetas con mensajes
git tag -n

# Filtrar etiquetas por patrón
git tag -l "v1.*"
```

### Eliminar etiquetas
```bash
# Eliminar etiqueta local
git tag -d v1.0.0

# Eliminar etiqueta remota
git push origin --delete v1.0.0
```

## Flujo de Trabajo

### 1. Desarrollo
- Trabajar en ramas feature: `feature/nombre-funcionalidad`
- Hacer commits descriptivos
- Crear pull requests para revisión

### 2. Testing
- Ejecutar tests antes de cada commit
- Verificar que no hay errores de linting
- Probar funcionalidades manualmente

### 3. Release
- Crear rama de release: `release/v1.x.x`
- Actualizar versiones en archivos de configuración
- Crear etiqueta de versión
- Generar changelog

### 4. Deploy
- Deploy automático desde rama main
- Verificar que la aplicación funciona correctamente
- Monitorear logs de error

## Estructura de Commits

Usar el formato Conventional Commits:
```
tipo(scope): descripción

[descripción opcional]

[footer opcional]
```

Tipos permitidos:
- `feat`: Nueva funcionalidad
- `fix`: Corrección de bugs
- `docs`: Cambios en documentación
- `style`: Cambios de formato
- `refactor`: Refactorización de código
- `test`: Añadir o modificar tests
- `chore`: Tareas de mantenimiento

## Changelog

### v1.1.0 (2024-10-30)
- ✅ Implementación de middlewares de seguridad
- ✅ Sistema de recuperación de contraseñas
- ✅ Validación robusta de datos de entrada
- ✅ Rate limiting avanzado
- ✅ Headers de seguridad
- ✅ Sanitización de entrada

### v1.0.0 (2024-10-15)
- ✅ Registro de usuarios
- ✅ Autenticación básica
- ✅ Sistema de viajes
- ✅ API endpoints básicos
