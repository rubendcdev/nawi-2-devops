# Sprint Backlog - NAWI (Taxi Seguro en Ocosingo)

## 📋 Resumen del Proyecto
**NAWI** es una plataforma de taxis seguros para Ocosingo, Chiapas, desarrollada con Laravel. El sistema conecta pasajeros con taxistas verificados y permite gestionar viajes, documentos y usuarios.

---

## ✅ Funcionalidades Completadas (Estado Actual)

### Autenticación y Autorización
- ✅ Sistema de autenticación API (Passport)
- ✅ Sistema de autenticación Web
- ✅ Registro de pasajeros y taxistas
- ✅ Gestión de roles (admin, taxista, pasajero)
- ✅ Middleware de autenticación

### Modelos y Base de Datos
- ✅ Modelos: Usuario, Pasajero, Taxista, Taxi, Viaje, Licencia, Matricula
- ✅ Modelo EstatusDocumento con relaciones
- ✅ Migraciones y seeders básicos
- ✅ Seeders para: EstatusDocumento, Genero, Idioma, Role

### Gestión de Documentos
- ✅ Modelo EstatusDocumento (pendiente, aprobado, rechazado)
- ✅ Servicio EstatusDocumentoService
- ✅ Subida de matrículas y licencias
- ✅ Panel de administración para revisar documentos

### API REST
- ✅ Endpoints para pasajeros (crear viaje, mis viajes, cancelar, calificar)
- ✅ Endpoints para taxistas (ver viajes disponibles, aceptar/rechazar, completar)
- ✅ Endpoints del sistema (estado de viaje, actualizar ubicación)
- ✅ Gestión de documentos de taxistas

### Frontend Web
- ✅ Vistas Blade básicas (welcome, home, perfil, taxistas)
- ✅ Panel de administración (dashboard)
- ✅ PWA configurado (manifest, service worker)
- ✅ Layout principal con navegación

### Servicios
- ✅ EstatusDocumentoService
- ✅ RoleService
- ✅ PaymentService (estructura)
- ✅ GeolocationService (estructura)
- ✅ ExternalApiService
- ✅ SecurityLoggerService

---

## 🎯 Sprint Backlog - Tareas Pendientes

### 🔴 Prioridad Alta (Crítico para MVP)

#### 1. Sistema de Notificaciones en Tiempo Real
- [ ] Implementar integración con Firebase/WebSockets para notificaciones push
- [ ] Notificar a taxistas cuando hay un nuevo viaje disponible
- [ ] Notificar a pasajeros cuando un taxista acepta su viaje
- [ ] Notificar cambios de estado en el viaje (en progreso, completado)
- [ ] **TODO identificado**: Implementar actualización a Firebase en `SistemaViajeController` (línea 104)

**Estimación**: 8-13 horas  
**Valor de negocio**: Alto

#### 2. Geocodificación Inversa
- [ ] Implementar servicio para convertir coordenadas GPS a direcciones legibles
- [ ] Integrar con API de geocodificación (Google Maps, Mapbox, o similar)
- [ ] Actualizar creación de viajes para almacenar direcciones automáticamente
- [ ] **TODO identificado**: Implementar geocodificación inversa en `PasajeroViajeController` (línea 66)

**Estimación**: 5-8 horas  
**Valor de negocio**: Alto

#### 3. Panel de Administración - Funcionalidades Adicionales
- [ ] Vista detallada de todos los documentos (no solo pendientes)
- [ ] Gestión de usuarios (ver, editar, desactivar)
- [ ] Estadísticas avanzadas (viajes completados, ingresos, taxistas activos)
- [ ] Historial de acciones de administración
- [ ] Exportación de reportes (PDF/Excel)

**Estimación**: 13-21 horas  
**Valor de negocio**: Alto

#### 4. Mapa Interactivo en Frontend
- [ ] Integrar mapa interactivo para seleccionar origen y destino
- [ ] Mostrar ubicación en tiempo real del taxista durante el viaje
- [ ] Visualizar taxistas disponibles en el mapa
- [ ] Ruta estimada entre origen y destino
- [ ] Integración con Google Maps API o Mapbox

**Estimación**: 13-21 horas  
**Valor de negocio**: Alto

#### 5. Sistema de Pagos
- [ ] Completar implementación de PaymentService
- [ ] Integración con pasarela de pagos (Stripe, MercadoPago, Conekta)
- [ ] Procesar pagos de viajes
- [ ] Historial de pagos
- [ ] Reembolsos por cancelaciones

**Estimación**: 13-21 horas  
**Valor de negocio**: Alto

---

### 🟡 Prioridad Media (Importante para Experiencia de Usuario)

#### 6. Mejoras en Gestión de Viajes
- [ ] Búsqueda y filtrado de viajes en panel admin
- [ ] Historial completo de viajes con detalles
- [ ] Estadísticas de viajes por taxista/pasajero
- [ ] Cancelación con penalizaciones/reglas
- [ ] Tiempo estimado de llegada calculado

**Estimación**: 8-13 horas  
**Valor de negocio**: Medio

#### 7. Sistema de Calificaciones Mejorado
- [ ] Calificación de taxistas por pasajeros
- [ ] Calificación de pasajeros por taxistas
- [ ] Promedio de calificaciones visible
- [ ] Historial de calificaciones
- [ ] Comentarios en calificaciones

**Estimación**: 5-8 horas  
**Valor de negocio**: Medio

#### 8. Perfil de Usuario Mejorado
- [ ] Edición completa de perfil (foto, datos personales)
- [ ] Cambio de contraseña
- [ ] Preferencias de usuario (idioma, notificaciones)
- [ ] Historial de viajes en perfil
- [ ] Métricas personales (viajes totales, calificación promedio)

**Estimación**: 5-8 horas  
**Valor de negocio**: Medio

#### 9. Dashboard de Taxista
- [ ] Vista de taxista con estadísticas personales
- [ ] Gestión de disponibilidad (disponible/no disponible)
- [ ] Historial de viajes del taxista
- [ ] Ingresos y estadísticas financieras
- [ ] Estado de documentos visible

**Estimación**: 8-13 horas  
**Valor de negocio**: Medio

#### 10. Validación y Seguridad Mejorada
- [ ] Validación de documentos (OCR para verificar datos)
- [ ] Verificación de identidad de taxistas
- [ ] Sistema de reportes de incidentes
- [ ] Bloqueo de usuarios por mal comportamiento
- [ ] Logs de seguridad detallados

**Estimación**: 13-21 horas  
**Valor de negocio**: Medio

---

### 🟢 Prioridad Baja (Mejoras y Optimizaciones)

#### 11. Suscripciones y Tarifas
- [ ] Completar modelo de Suscripcion
- [ ] Gestión de planes de suscripción para taxistas
- [ ] Cálculo dinámico de tarifas según distancia
- [ ] Tarifas especiales (horas pico, festivos)
- [ ] Sistema de descuentos y promociones

**Estimación**: 13-21 horas  
**Valor de negocio**: Bajo-Medio

#### 12. Multilenguaje
- [ ] Completar sistema de idiomas (modelo Idioma existe)
- [ ] Traducciones para español, tzeltal, tzotzil
- [ ] Cambio de idioma en la interfaz
- [ ] Notificaciones en idioma preferido

**Estimación**: 8-13 horas  
**Valor de negocio**: Bajo-Medio

#### 13. Reportes y Analytics
- [ ] Dashboard de analytics con gráficas
- [ ] Reportes de uso de la plataforma
- [ ] Análisis de rutas más frecuentes
- [ ] Reportes financieros
- [ ] Exportación de datos

**Estimación**: 8-13 horas  
**Valor de negocio**: Bajo

#### 14. Optimización de Performance
- [ ] Caché de consultas frecuentes
- [ ] Optimización de queries (eager loading)
- [ ] Compresión de imágenes
- [ ] Lazy loading en frontend
- [ ] CDN para assets estáticos

**Estimación**: 5-8 horas  
**Valor de negocio**: Bajo

#### 15. Testing
- [ ] Tests unitarios para modelos
- [ ] Tests de integración para API
- [ ] Tests de funcionalidad para controladores
- [ ] Tests de servicios
- [ ] Cobertura mínima del 70%

**Estimación**: 13-21 horas  
**Valor de negocio**: Bajo (aunque importante para calidad)

#### 16. Documentación
- [ ] Documentación de API (Swagger/OpenAPI)
- [ ] Guía de instalación y configuración
- [ ] Documentación de servicios
- [ ] Manual de usuario
- [ ] Guía para desarrolladores

**Estimación**: 8-13 horas  
**Valor de negocio**: Bajo

#### 17. Mejoras de UI/UX
- [ ] Diseño responsive mejorado
- [ ] Animaciones y transiciones suaves
- [ ] Mejora de accesibilidad (WCAG)
- [ ] Modo oscuro
- [ ] Mejoras visuales en dashboard admin

**Estimación**: 8-13 horas  
**Valor de negocio**: Bajo

---

## 📊 Resumen de Estimaciones

| Prioridad | Cantidad de Tareas | Horas Estimadas |
|-----------|-------------------|-----------------|
| Alta | 5 | 52-78 horas |
| Media | 5 | 31-47 horas |
| Baja | 7 | 55-83 horas |
| **Total** | **17** | **138-208 horas** |

---

## 🎯 Recomendación para Próximo Sprint

### Sprint 1 - MVP Crítico (2-3 semanas)
1. Sistema de Notificaciones en Tiempo Real
2. Geocodificación Inversa
3. Mapa Interactivo en Frontend
4. Panel de Administración - Funcionalidades Adicionales

**Total estimado**: 39-58 horas

### Sprint 2 - Pagos y Experiencia (2 semanas)
1. Sistema de Pagos
2. Mejoras en Gestión de Viajes
3. Sistema de Calificaciones Mejorado
4. Dashboard de Taxista

**Total estimado**: 31-47 horas

### Sprint 3 - Optimización y Calidad (2 semanas)
1. Validación y Seguridad Mejorada
2. Perfil de Usuario Mejorado
3. Testing básico
4. Optimización de Performance

**Total estimado**: 31-47 horas

---

## 📝 Notas Adicionales

- **TODOs identificados en código**:
  - `SistemaViajeController.php` línea 104: Implementar actualización a Firebase
  - `PasajeroViajeController.php` línea 66: Implementar geocodificación inversa

- **Tecnologías a considerar**:
  - Firebase Cloud Messaging (FCM) para notificaciones push
  - Google Maps API o Mapbox para mapas
  - Laravel Echo + Pusher o WebSockets para tiempo real
  - Stripe/MercadoPago para pagos

- **Dependencias pendientes**:
  - Verificar si PaymentService está completamente implementado
  - Verificar si GeolocationService tiene funcionalidad completa
  - Revisar integración de ExternalApiService

---

**Última actualización**: Diciembre 2024  
**Versión del backlog**: 1.0

