# Revisión de Configuración .env - NAWI

## ✅ Configuración Actual Detectada

Basado en la revisión de la configuración de Laravel, estas son las variables que están actualmente configuradas:

### Configuración de Email ✅

```
MAIL_MAILER: smtp
MAIL_HOST: smtp.gmail.com
MAIL_PORT: 587
MAIL_ENCRYPTION: tls
MAIL_FROM_ADDRESS: noreply@nawi.com
MAIL_FROM_NAME: NAWI
```

### Estado: ✅ Configuración Básica Correcta

---

## ⚠️ Variables que Necesitan Verificación

Estas variables **NO** se pueden verificar automáticamente por seguridad, pero **DEBEN** estar configuradas en tu `.env`:

### Variables Requeridas para SMTP:

```env
MAIL_USERNAME=tu-email@gmail.com
MAIL_PASSWORD=tu-contraseña-o-app-password
```

**⚠️ IMPORTANTE:** 
- Si usas Gmail, necesitas una **"Contraseña de aplicación"**, no tu contraseña normal
- Para obtenerla: https://myaccount.google.com/apppasswords

---

## 📋 Checklist de Configuración

### ✅ Configurado Correctamente:
- [x] `MAIL_MAILER=smtp`
- [x] `MAIL_HOST=smtp.gmail.com`
- [x] `MAIL_PORT=587`
- [x] `MAIL_ENCRYPTION=tls`
- [x] `MAIL_FROM_ADDRESS=noreply@nawi.com`
- [x] `MAIL_FROM_NAME=NAWI`

### ⚠️ Requiere Verificación Manual:
- [ ] `MAIL_USERNAME` - Debe ser tu email de Gmail
- [ ] `MAIL_PASSWORD` - Debe ser una contraseña de aplicación si usas Gmail

---

## 🔧 Configuración Recomendada Completa

Copia y pega esto en tu archivo `.env` (reemplaza los valores):

```env
# Configuración de Email
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@gmail.com
MAIL_PASSWORD=tu-contraseña-de-aplicacion
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@nawi.com
MAIL_FROM_NAME="${APP_NAME}"
```

---

## 🧪 Cómo Verificar que Funciona

### 1. Verificar que las variables están cargadas:

```bash
php artisan tinker
```

Luego ejecuta:
```php
config('mail.mailers.smtp.username')  // Debe mostrar tu email
config('mail.mailers.smtp.password') // Debe mostrar tu contraseña (no se muestra por seguridad)
```

### 2. Probar envío de email:

```php
use Illuminate\Support\Facades\Mail;
Mail::raw('Test email', function ($message) {
    $message->to('tu-email@example.com')
            ->subject('Test Email NAWI');
});
```

Si no hay errores, el email debería enviarse.

### 3. Probar recuperación de contraseña:

```bash
curl -X POST http://localhost/api/password/forgot \
  -H "Content-Type: application/json" \
  -d '{"email": "usuario@example.com"}'
```

---

## 🔍 Troubleshooting

### Si los emails no se envían:

1. **Verifica que las variables estén en `.env`** (no solo en `.env.example`)
2. **Limpiar caché de configuración:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

3. **Verifica logs:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

4. **Usa modo debug temporal:**
   ```env
   MAIL_MAILER=log
   ```
   Esto guardará los emails en `storage/logs/laravel.log` en lugar de enviarlos.

### Error: "Authentication failed"

**Solución:**
- Si usas Gmail, asegúrate de usar una **"Contraseña de aplicación"**
- Activa la verificación en 2 pasos en Google
- Genera una contraseña de aplicación en: https://myaccount.google.com/apppasswords

### Error: "Connection could not be established"

**Solución:**
- Verifica que `MAIL_HOST` y `MAIL_PORT` sean correctos
- Verifica tu conexión a internet
- Prueba con otro servidor SMTP

---

## 📝 Variables Adicionales Opcionales

Estas variables pueden ser útiles pero no son obligatorias:

```env
# Timeout para conexiones SMTP (en segundos)
MAIL_TIMEOUT=30

# Dominio EHLO (opcional)
MAIL_EHLO_DOMAIN=

# Canal de logs para emails (si usas MAIL_MAILER=log)
MAIL_LOG_CHANNEL=stack
```

---

## ✅ Resumen

### Estado Actual:
- ✅ Configuración básica correcta
- ✅ Valores de SMTP configurados
- ⚠️ Necesita verificar `MAIL_USERNAME` y `MAIL_PASSWORD`

### Próximos Pasos:
1. Verificar que `MAIL_USERNAME` y `MAIL_PASSWORD` estén en `.env`
2. Si usas Gmail, crear una contraseña de aplicación
3. Limpiar caché: `php artisan config:clear`
4. Probar envío de email

---

**Fecha de revisión**: Diciembre 2024

