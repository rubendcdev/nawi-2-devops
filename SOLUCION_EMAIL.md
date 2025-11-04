# Solución al Problema de Email - NAWI

## 🔴 Problema Detectado

El error en los logs indica:
```
Failed to authenticate on SMTP server
Username and Password not accepted
```

**Causa:** Gmail ya no permite usar contraseñas normales para aplicaciones. Necesitas una **"Contraseña de aplicación"**.

---

## ✅ Solución Paso a Paso

### Paso 1: Activar Verificación en 2 Pasos

1. Ve a: https://myaccount.google.com/security
2. Busca "Verificación en dos pasos"
3. Actívala si no está activada

### Paso 2: Generar Contraseña de Aplicación

1. Ve a: https://myaccount.google.com/apppasswords
2. Selecciona:
   - **Aplicación:** Correo
   - **Dispositivo:** Otro (nombre personalizado)
   - **Nombre:** NAWI
3. Haz clic en "Generar"
4. **Copia la contraseña de 16 caracteres** (sin espacios)

### Paso 3: Actualizar .env

Edita tu archivo `.env` y reemplaza `MAIL_PASSWORD`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=nawitech630@gmail.com
MAIL_PASSWORD=abcd efgh ijkl mnop  # ← Pega aquí la contraseña de aplicación (16 caracteres SIN espacios)
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=nawitech630@gmail.com
MAIL_FROM_NAME="NAWI"
```

**⚠️ IMPORTANTE:** 
- Usa la contraseña de aplicación de 16 caracteres
- Si tiene espacios, quítalos o ponla entre comillas
- Ejemplo: `MAIL_PASSWORD="abcd efgh ijkl mnop"` o `MAIL_PASSWORD=abcdefghijklmnop`

### Paso 4: Limpiar Caché

```bash
php artisan config:clear
php artisan cache:clear
```

### Paso 5: Probar

Vuelve a intentar solicitar la recuperación de contraseña. Ahora debería funcionar.

---

## 🔍 Verificar que Funciona

### Opción 1: Verificar en los logs

Después de intentar enviar el email, revisa:
```bash
tail -f storage/logs/laravel.log
```

Si no hay errores, el email se envió correctamente.

### Opción 2: Probar directamente

```bash
php artisan tinker
```

Luego:
```php
use Illuminate\Support\Facades\Mail;

Mail::raw('Test email', function ($message) {
    $message->to('tu-email@example.com')
            ->subject('Test Email NAWI');
});
```

Si no hay errores, funcionará.

---

## 📋 Configuración Final Recomendada

```env
# Email Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=nawitech630@gmail.com
MAIL_PASSWORD=TU_CONTRASEÑA_DE_APLICACION_DE_16_CARACTERES
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=nawitech630@gmail.com
MAIL_FROM_NAME="NAWI"
```

---

## 🆘 Si Aún No Funciona

### Verificar que la contraseña de aplicación esté correcta:
- Debe tener exactamente 16 caracteres
- No debe tener espacios (o estar entre comillas)
- Debe ser reciente (generada hace menos de unos minutos)

### Verificar que el email esté correcto:
- `MAIL_USERNAME` debe ser exactamente `nawitech630@gmail.com`
- `MAIL_FROM_ADDRESS` puede ser el mismo o `noreply@nawi.com`

### Verificar configuración SMTP:
- `MAIL_HOST=smtp.gmail.com`
- `MAIL_PORT=587`
- `MAIL_ENCRYPTION=tls`

### Limpiar caché:
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

---

## 📝 Nota Importante

**NUNCA** uses tu contraseña normal de Gmail. Siempre usa una **"Contraseña de aplicación"** para aplicaciones de terceros.

---

**Fecha**: Diciembre 2024

