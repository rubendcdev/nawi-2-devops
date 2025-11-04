# Configuración de Email - NAWI

## 📧 Configuración de Laravel Mail para Recuperación de Contraseña

Este documento explica cómo configurar el envío de emails para la funcionalidad de recuperación de contraseña.

---

## 🔧 Configuración en el archivo .env

Edita el archivo `.env` en la raíz del proyecto y agrega las siguientes variables:

### Opción 1: SMTP (Gmail, Outlook, etc.)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@gmail.com
MAIL_PASSWORD=tu-contraseña-de-aplicacion
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@nawi.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Opción 2: Gmail con App Password

Si usas Gmail, necesitas crear una "Contraseña de aplicación":

1. Ve a tu cuenta de Google: https://myaccount.google.com/
2. Activa la verificación en 2 pasos
3. Ve a "Contraseñas de aplicaciones": https://myaccount.google.com/apppasswords
4. Genera una contraseña para "Correo"
5. Usa esa contraseña en `MAIL_PASSWORD`

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@gmail.com
MAIL_PASSWORD=abcd efgh ijkl mnop  # Contraseña de aplicación de 16 caracteres
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu-email@gmail.com
MAIL_FROM_NAME="NAWI"
```

### Opción 3: Mailtrap (Para desarrollo/pruebas)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=tu-username-de-mailtrap
MAIL_PASSWORD=tu-password-de-mailtrap
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@nawi.com
MAIL_FROM_NAME="NAWI"
```

### Opción 4: Sendmail (Servidor local)

```env
MAIL_MAILER=sendmail
MAIL_FROM_ADDRESS=noreply@nawi.com
MAIL_FROM_NAME="NAWI"
```

### Opción 5: Log (Para desarrollo - solo guarda en logs)

```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@nawi.com
MAIL_FROM_NAME="NAWI"
```

---

## 📋 Endpoints de la API

### POST /api/password/forgot

Solicita un enlace de recuperación de contraseña.

**Request:**
```json
{
    "email": "usuario@example.com"
}
```

**Response (éxito):**
```json
{
    "success": true,
    "message": "Se ha enviado un enlace de recuperación a tu email",
    "expires_at": "2024-12-16T15:30:00.000000Z"
}
```

**Response (error):**
```json
{
    "success": false,
    "message": "Datos inválidos",
    "errors": {
        "email": ["El formato del email no es válido"]
    }
}
```

### POST /api/password/reset

Restablece la contraseña usando el token recibido por email.

**Request:**
```json
{
    "email": "usuario@example.com",
    "token": "token-de-64-caracteres-recibido-por-email",
    "password": "NuevaContraseña123!",
    "password_confirmation": "NuevaContraseña123!"
}
```

**Requisitos de contraseña:**
- Mínimo 8 caracteres
- Al menos una letra minúscula
- Al menos una letra mayúscula
- Al menos un número
- Al menos un símbolo especial (@$!%*?&)

**Response (éxito):**
```json
{
    "success": true,
    "message": "Contraseña actualizada exitosamente"
}
```

**Response (error):**
```json
{
    "success": false,
    "message": "Token inválido o expirado",
    "code": "INVALID_TOKEN"
}
```

### POST /api/password/verify-token

Verifica si un token de recuperación es válido.

**Request:**
```json
{
    "email": "usuario@example.com",
    "token": "token-de-64-caracteres"
}
```

**Response (éxito):**
```json
{
    "success": true,
    "message": "Token válido",
    "expires_at": "2024-12-16T15:30:00.000000Z"
}
```

---

## 🧪 Probar el envío de emails

### 1. Verificar configuración

Ejecuta el siguiente comando para verificar que Laravel puede enviar emails:

```bash
php artisan tinker
```

Luego en tinker:

```php
use Illuminate\Support\Facades\Mail;
Mail::raw('Test email', function ($message) {
    $message->to('tu-email@example.com')
            ->subject('Test Email');
});
```

### 2. Probar recuperación de contraseña

Usa Postman, cURL o tu cliente HTTP favorito:

```bash
curl -X POST http://localhost/api/password/forgot \
  -H "Content-Type: application/json" \
  -d '{"email": "usuario@example.com"}'
```

### 3. Ver logs (si usas MAIL_MAILER=log)

Los emails se guardarán en `storage/logs/laravel.log`

---

## 🔍 Troubleshooting

### Error: "Connection could not be established"

**Solución:**
- Verifica que `MAIL_HOST` y `MAIL_PORT` sean correctos
- Asegúrate de que el servidor tenga acceso a internet
- Verifica el firewall

### Error: "Authentication failed"

**Solución:**
- Verifica `MAIL_USERNAME` y `MAIL_PASSWORD`
- Si usas Gmail, asegúrate de usar una "Contraseña de aplicación"
- Verifica que `MAIL_ENCRYPTION` sea correcto (tls o ssl)

### Los emails no se envían

**Solución:**
1. Verifica que las variables estén en `.env` (no en `.env.example`)
2. Ejecuta `php artisan config:clear` después de cambiar `.env`
3. Verifica los logs en `storage/logs/laravel.log`
4. Usa `MAIL_MAILER=log` para depurar

### Email llega a spam

**Solución:**
- Usa un servicio profesional como Mailgun, SendGrid o AWS SES
- Configura SPF y DKIM en tu dominio
- Usa un email con dominio propio (no @gmail.com)

---

## 📚 Servicios de Email Recomendados

### Para Producción:

1. **Mailgun** (Recomendado)
   - 5,000 emails gratis al mes
   - Fácil configuración
   - Excelente deliverability

2. **SendGrid**
   - 100 emails gratis al día
   - API robusta
   - Buen tracking

3. **AWS SES**
   - Muy económico
   - Requiere cuenta AWS
   - Excelente para alto volumen

4. **Postmark**
   - Excelente para transaccionales
   - 100 emails gratis al mes
   - Buen tracking

---

## 🔐 Seguridad

- **Nunca** subas el archivo `.env` al repositorio
- Usa contraseñas de aplicación, no tu contraseña principal
- Limita el acceso al servidor SMTP
- Considera usar variables de entorno en producción

---

## 📝 Template de Email

El template de email se encuentra en:
`resources/views/emails/password-reset.blade.php`

Puedes personalizarlo editando ese archivo.

---

**Última actualización**: Diciembre 2024

