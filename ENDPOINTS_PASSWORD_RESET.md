# Endpoints de Recuperación de Contraseña - NAWI API

## 📋 Resumen

Esta documentación describe los endpoints disponibles para la recuperación de contraseña en la API de NAWI.

---

## 🔐 Endpoints Disponibles

### 1. POST /api/password/forgot

Solicita un enlace de recuperación de contraseña por email.

**URL:** `/api/password/forgot`

**Método:** `POST`

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Body:**
```json
{
    "email": "usuario@example.com"
}
```

**Respuesta Exitosa (200):**
```json
{
    "success": true,
    "message": "Se ha enviado un enlace de recuperación a tu email",
    "expires_at": "2024-12-16T15:30:00.000000Z"
}
```

**Respuestas de Error:**

- **422 - Validación fallida:**
```json
{
    "success": false,
    "message": "Datos inválidos",
    "errors": {
        "email": ["El formato del email no es válido"]
    }
}
```

- **429 - Demasiadas solicitudes:**
```json
{
    "success": false,
    "message": "Has excedido el límite de solicitudes de recuperación. Intenta de nuevo en 1 hora.",
    "code": "TOO_MANY_REQUESTS"
}
```

**Ejemplo con cURL:**
```bash
curl -X POST http://localhost/api/password/forgot \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"email": "usuario@example.com"}'
```

**Ejemplo con JavaScript (Fetch):**
```javascript
fetch('http://localhost/api/password/forgot', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    },
    body: JSON.stringify({
        email: 'usuario@example.com'
    })
})
.then(response => response.json())
.then(data => console.log(data));
```

---

### 2. POST /api/password/reset

Restablece la contraseña usando el token recibido por email.

**URL:** `/api/password/reset`

**Método:** `POST`

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Body:**
```json
{
    "email": "usuario@example.com",
    "token": "token-de-64-caracteres-recibido-por-email",
    "password": "NuevaContraseña123!",
    "password_confirmation": "NuevaContraseña123!"
}
```

**Requisitos de Contraseña:**
- ✅ Mínimo 8 caracteres
- ✅ Al menos una letra minúscula (a-z)
- ✅ Al menos una letra mayúscula (A-Z)
- ✅ Al menos un número (0-9)
- ✅ Al menos un símbolo especial (@$!%*?&)

**Respuesta Exitosa (200):**
```json
{
    "success": true,
    "message": "Contraseña actualizada exitosamente"
}
```

**Respuestas de Error:**

- **422 - Validación fallida:**
```json
{
    "success": false,
    "message": "Datos inválidos",
    "errors": {
        "password": ["La contraseña debe contener al menos una letra minúscula, una mayúscula, un número y un símbolo especial"]
    }
}
```

- **400 - Token inválido o expirado:**
```json
{
    "success": false,
    "message": "Token inválido o expirado",
    "code": "INVALID_TOKEN"
}
```

- **404 - Usuario no encontrado:**
```json
{
    "success": false,
    "message": "Usuario no encontrado"
}
```

**Ejemplo con cURL:**
```bash
curl -X POST http://localhost/api/password/reset \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "email": "usuario@example.com",
    "token": "abcdef1234567890abcdef1234567890abcdef1234567890abcdef1234567890",
    "password": "NuevaContraseña123!",
    "password_confirmation": "NuevaContraseña123!"
  }'
```

**Ejemplo con JavaScript (Fetch):**
```javascript
fetch('http://localhost/api/password/reset', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    },
    body: JSON.stringify({
        email: 'usuario@example.com',
        token: 'token-de-64-caracteres',
        password: 'NuevaContraseña123!',
        password_confirmation: 'NuevaContraseña123!'
    })
})
.then(response => response.json())
.then(data => console.log(data));
```

---

### 3. POST /api/password/verify-token (Opcional)

Verifica si un token de recuperación es válido antes de mostrar el formulario de restablecimiento.

**URL:** `/api/password/verify-token`

**Método:** `POST`

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Body:**
```json
{
    "email": "usuario@example.com",
    "token": "token-de-64-caracteres"
}
```

**Respuesta Exitosa (200):**
```json
{
    "success": true,
    "message": "Token válido",
    "expires_at": "2024-12-16T15:30:00.000000Z"
}
```

**Respuesta de Error (400):**
```json
{
    "success": false,
    "message": "Token inválido o expirado",
    "code": "INVALID_TOKEN"
}
```

---

## 🔄 Flujo Completo de Recuperación

### Paso 1: Usuario solicita recuperación
```http
POST /api/password/forgot
Content-Type: application/json

{
    "email": "usuario@example.com"
}
```

**Resultado:** El sistema envía un email con un enlace de recuperación.

### Paso 2: Usuario recibe email
El email contiene:
- Un enlace: `https://tudominio.com/password/reset/{token}?email=usuario@example.com`
- Instrucciones de uso
- Tiempo de expiración (60 minutos)

### Paso 3: Usuario restablece contraseña
```http
POST /api/password/reset
Content-Type: application/json

{
    "email": "usuario@example.com",
    "token": "token-del-email",
    "password": "NuevaContraseña123!",
    "password_confirmation": "NuevaContraseña123!"
}
```

**Resultado:** Contraseña actualizada exitosamente.

---

## 🛡️ Seguridad

### Limitaciones Implementadas:

1. **Rate Limiting:**
   - Máximo 3 solicitudes por hora por email
   - Protección contra abuso del sistema

2. **Token Seguro:**
   - Tokens de 64 caracteres aleatorios
   - Tokens encriptados con Hash::make() antes de almacenar
   - Expiración automática después de 60 minutos

3. **Validación de Contraseña:**
   - Requisitos estrictos para contraseñas seguras
   - Confirmación de contraseña requerida

4. **Validación de Email:**
   - Verificación de formato de email
   - Verificación de existencia del email en la base de datos

---

## 📧 Configuración de Email

Para que el envío de emails funcione correctamente, configura las variables en tu archivo `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@gmail.com
MAIL_PASSWORD=tu-contraseña
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@nawi.com
MAIL_FROM_NAME="NAWI"
```

Para más detalles, consulta `CONFIGURACION_EMAIL.md`.

---

## 🧪 Testing

### Probar con Postman:

1. **Crear solicitud POST a `/api/password/forgot`**
   - Body: `{"email": "test@example.com"}`
   - Headers: `Content-Type: application/json`

2. **Verificar email recibido**
   - Revisar bandeja de entrada o spam
   - Copiar el token del enlace

3. **Crear solicitud POST a `/api/password/reset`**
   - Body con email, token y nueva contraseña
   - Verificar respuesta exitosa

### Probar con cURL:

```bash
# 1. Solicitar recuperación
curl -X POST http://localhost/api/password/forgot \
  -H "Content-Type: application/json" \
  -d '{"email": "test@example.com"}'

# 2. Restablecer contraseña (usar token del email)
curl -X POST http://localhost/api/password/reset \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@example.com",
    "token": "TOKEN_DEL_EMAIL",
    "password": "NuevaPass123!",
    "password_confirmation": "NuevaPass123!"
  }'
```

---

## 📝 Notas Importantes

1. **Tokens de 64 caracteres:** El token debe tener exactamente 64 caracteres
2. **Expiración:** Los tokens expiran después de 60 minutos
3. **Uso único:** Cada token solo puede usarse una vez
4. **Email requerido:** El email debe existir en la tabla `usuarios`
5. **Límite de intentos:** Máximo 3 solicitudes por hora por email

---

## 🔗 Endpoints Relacionados

- `POST /api/login` - Iniciar sesión después de recuperar contraseña
- `POST /api/register/pasajero` - Registro de pasajero
- `POST /api/register/taxista` - Registro de taxista

---

**Última actualización**: Diciembre 2024  
**Versión de la API**: 1.0

