# API Endpoints - Sistema de Viajes

## Autenticación
Todos los endpoints requieren autenticación con token Bearer.

## Endpoints para Pasajeros

### 1. Crear Viaje
```
POST /api/pasajero/crear-viaje
```
**Headers:** `Authorization: Bearer {token}`

**Body:**
```json
{
  "id_pasajero": "user123",
  "salida": {"lat": 16.867, "lon": -92.094},
  "destino": {"lat": 16.900, "lon": -92.100},
  "comentario": "Comentario opcional"
}
```

**Respuesta:**
```json
{
  "success": true,
  "message": "Viaje creado exitosamente",
  "data": {
    "id": "uuid-del-viaje",
    "estado": "pendiente",
    "salida": {"lat": 16.867, "lon": -92.094},
    "destino": {"lat": 16.900, "lon": -92.100},
    "comentario": "Comentario opcional",
    "created_at": "2025-09-26T17:30:00Z"
  }
}
```

### 2. Obtener Mis Viajes
```
GET /api/pasajero/mis-viajes
```
**Headers:** `Authorization: Bearer {token}`

**Respuesta:**
```json
{
  "success": true,
  "data": [
    {
      "id": "uuid-del-viaje",
      "estado": "completado",
      "salida": {"lat": 16.867, "lon": -92.094},
      "destino": {"lat": 16.900, "lon": -92.100},
      "taxi": {
        "id": "uuid-del-taxi",
        "numero_taxi": "TAX-001",
        "taxista": {
          "nombre": "Juan Pérez",
          "telefono": "555-1234"
        }
      },
      "comentario": "Comentario del viaje",
      "calificacion": {
        "calificacion": "5",
        "comentario": "Excelente servicio"
      },
      "created_at": "2025-09-26T17:30:00Z"
    }
  ]
}
```

### 3. Cancelar Viaje
```
POST /api/pasajero/cancelar-viaje/{id}
```
**Headers:** `Authorization: Bearer {token}`

**Respuesta:**
```json
{
  "success": true,
  "message": "Viaje cancelado exitosamente",
  "data": {
    "id": "uuid-del-viaje",
    "estado": "cancelado"
  }
}
```

### 4. Calificar Viaje
```
POST /api/pasajero/calificar-viaje/{id}
```
**Headers:** `Authorization: Bearer {token}`

**Body:**
```json
{
  "calificacion": 5,
  "comentario": "Excelente servicio"
}
```

**Respuesta:**
```json
{
  "success": true,
  "message": "Viaje calificado exitosamente",
  "data": {
    "calificacion": 5,
    "comentario": "Excelente servicio"
  }
}
```

## Endpoints para Taxistas

### 1. Obtener Viajes Disponibles
```
GET /api/taxista/viajes-disponibles
```
**Headers:** `Authorization: Bearer {token}`

**Respuesta:**
```json
{
  "success": true,
  "data": [
    {
      "id": "uuid-del-viaje",
      "salida": {"lat": 16.867, "lon": -92.094},
      "destino": {"lat": 16.900, "lon": -92.100},
      "pasajero": {
        "nombre": "María García",
        "telefono": "555-5678"
      },
      "comentario": "Comentario del viaje",
      "created_at": "2025-09-26T17:30:00Z"
    }
  ]
}
```

### 2. Aceptar Viaje
```
POST /api/taxista/aceptar-viaje/{id}
```
**Headers:** `Authorization: Bearer {token}`

**Respuesta:**
```json
{
  "success": true,
  "message": "Viaje aceptado exitosamente",
  "data": {
    "id": "uuid-del-viaje",
    "estado": "aceptado",
    "taxi_id": "uuid-del-taxi"
  }
}
```

### 3. Rechazar Viaje
```
POST /api/taxista/rechazar-viaje/{id}
```
**Headers:** `Authorization: Bearer {token}`

**Respuesta:**
```json
{
  "success": true,
  "message": "Viaje rechazado (no se requiere acción en BD)"
}
```

### 4. Completar Viaje
```
POST /api/taxista/completar-viaje/{id}
```
**Headers:** `Authorization: Bearer {token}`

**Respuesta:**
```json
{
  "success": true,
  "message": "Viaje completado exitosamente",
  "data": {
    "id": "uuid-del-viaje",
    "estado": "completado"
  }
}
```

### 5. Obtener Mis Viajes (Taxista)
```
GET /api/taxista/mis-viajes
```
**Headers:** `Authorization: Bearer {token}`

**Respuesta:** Similar a la respuesta de "mis-viajes" del pasajero, pero con información del pasajero en lugar del taxista.

## Endpoints Generales

### 1. Obtener Estado de Viaje
```
GET /api/viaje/estado/{id}
```
**Headers:** `Authorization: Bearer {token}`

**Respuesta:**
```json
{
  "success": true,
  "data": {
    "id": "uuid-del-viaje",
    "estado": "en_curso",
    "salida": {"lat": 16.867, "lon": -92.094},
    "destino": {"lat": 16.900, "lon": -92.100},
    "ubicacion_actual": {"lat": 16.880, "lon": -92.095},
    "taxi": {
      "id": "uuid-del-taxi",
      "numero_taxi": "TAX-001",
      "taxista": {
        "nombre": "Juan Pérez",
        "telefono": "555-1234"
      }
    },
    "pasajero": {
      "nombre": "María García",
      "telefono": "555-5678"
    },
    "comentario": "Comentario del viaje",
    "calificacion": null,
    "created_at": "2025-09-26T17:30:00Z",
    "updated_at": "2025-09-26T17:35:00Z"
  }
}
```

### 2. Actualizar Ubicación en Tiempo Real
```
POST /api/viaje/actualizar-ubicacion/{id}
```
**Headers:** `Authorization: Bearer {token}`

**Body:**
```json
{
  "lat": 16.880,
  "lon": -92.095
}
```

**Respuesta:**
```json
{
  "success": true,
  "message": "Ubicación actualizada exitosamente",
  "data": {
    "id": "uuid-del-viaje",
    "ubicacion_actual": {
      "lat": 16.880,
      "lon": -92.095
    }
  }
}
```

## Estados de Viaje

- `pendiente`: Viaje creado, esperando taxista
- `aceptado`: Taxista aceptó el viaje
- `en_curso`: Viaje en progreso
- `completado`: Viaje finalizado
- `cancelado`: Viaje cancelado

## Seguridad

### Rate Limiting
- **Pasajeros:** 30 requests por minuto
- **Taxistas:** 60 requests por minuto  
- **Endpoints generales:** 120 requests por minuto

### Validación de Permisos
- Los endpoints de pasajero requieren que el usuario sea un pasajero
- Los endpoints de taxista requieren que el usuario sea un taxista
- Solo el taxista asignado puede completar/actualizar ubicación de un viaje
- Solo el pasajero puede cancelar/calificar sus propios viajes

### Códigos de Error Comunes

- `400`: Datos de entrada inválidos
- `401`: No autenticado
- `403`: Acceso denegado (tipo de usuario incorrecto)
- `404`: Recurso no encontrado
- `429`: Demasiadas solicitudes (rate limit)
- `500`: Error interno del servidor

## Ejemplos de Uso

### Flujo Completo de un Viaje

1. **Pasajero crea viaje:**
   ```bash
   POST /api/pasajero/crear-viaje
   ```

2. **Taxista ve viajes disponibles:**
   ```bash
   GET /api/taxista/viajes-disponibles
   ```

3. **Taxista acepta viaje:**
   ```bash
   POST /api/taxista/aceptar-viaje/{id}
   ```

4. **Taxista actualiza ubicación:**
   ```bash
   POST /api/viaje/actualizar-ubicacion/{id}
   ```

5. **Taxista completa viaje:**
   ```bash
   POST /api/taxista/completar-viaje/{id}
   ```

6. **Pasajero califica viaje:**
   ```bash
   POST /api/pasajero/calificar-viaje/{id}
   ```




