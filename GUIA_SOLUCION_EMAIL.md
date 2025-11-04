# 🔧 Guía de Solución: Error de Autenticación Gmail

## 🔴 Error Actual

```
Failed to authenticate on SMTP server
Username and Password not accepted
```

**Email configurado:** `guillenmariana550@gmail.com`

---

## ✅ Solución: Usar Contraseña de Aplicación de Gmail

Gmail **NO permite** usar tu contraseña normal para aplicaciones. Debes generar una **"Contraseña de aplicación"** especial.

---

## 📋 Pasos para Solucionar

### Paso 1: Activar Verificación en 2 Pasos

1. Abre: https://myaccount.google.com/security
2. Busca la sección **"Verificación en dos pasos"**
3. Si no está activada, **actívala** (es obligatorio para generar contraseñas de aplicación)

### Paso 2: Generar Contraseña de Aplicación

1. Ve a: https://myaccount.google.com/apppasswords
   - Si no aparece, primero activa la verificación en 2 pasos
2. En la página de "Contraseñas de aplicaciones":
   - Selecciona **"Correo"** en el menú desplegable
   - Selecciona **"Otro (nombre personalizado)"** en dispositivo
   - Escribe: **"NAWI"**
   - Haz clic en **"Generar"**
3. **Copia la contraseña de 16 caracteres** que aparece
   - Se verá algo como: `abcd efgh ijkl mnop`
   - **IMPORTANTE:** Copia los 16 caracteres (con o sin espacios, ambos funcionan)

### Paso 3: Actualizar archivo .env

Abre tu archivo `.env` y actualiza estas líneas:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=guillenmariana550@gmail.com
MAIL_PASSWORD=abcdefghijklmnop  # ← Pega aquí la contraseña de aplicación de 16 caracteres
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=guillenmariana550@gmail.com
MAIL_FROM_NAME="NAWI"
```

**Opciones para MAIL_PASSWORD:**

**Opción 1:** Sin espacios
```env
MAIL_PASSWORD=abcdefghijklmnop
```

**Opción 2:** Con espacios entre comillas
```env
MAIL_PASSWORD="abcd efgh ijkl mnop"
```

### Paso 4: Limpiar Caché de Laravel

Después de actualizar `.env`, **SIEMPRE** limpia la caché:

```bash
php artisan config:clear
php artisan cache:clear
```

**⚠️ CRÍTICO:** Sin limpiar la caché, Laravel seguirá usando la configuración anterior.

### Paso 5: Verificar Configuración

Ejecuta para verificar que se cargó correctamente:

```bash
php artisan config:show mail.mailers.smtp
```

Deberías ver:
- `username` = `guillenmariana550@gmail.com`
- `password` = (configurado, no se muestra por seguridad)
- `host` = `smtp.gmail.com`
- `port` = `587`
- `encryption` = `tls`

### Paso 6: Probar

Intenta solicitar la recuperación de contraseña nuevamente. Ahora debería funcionar.

---

## 🔍 Verificación Rápida

### ¿Tienes la verificación en 2 pasos activada?
- ✅ Sí → Continúa al paso 2
- ❌ No → Actívala primero en https://myaccount.google.com/security

### ¿Generaste la contraseña de aplicación?
- ✅ Sí → Úsala en `MAIL_PASSWORD`
- ❌ No → Ve a https://myaccount.google.com/apppasswords

### ¿Limpiaste la caché después de actualizar .env?
- ✅ Sí → Perfecto
- ❌ No → Ejecuta `php artisan config:clear`

---

## 🆘 Si Aún No Funciona

### Checklist de Verificación:

1. ✅ **Verificación en 2 pasos activada** en Google
2. ✅ **Contraseña de aplicación generada** (16 caracteres)
3. ✅ **MAIL_USERNAME** = `guillenmariana550@gmail.com` (exacto, sin espacios)
4. ✅ **MAIL_PASSWORD** = Contraseña de aplicación (16 caracteres)
5. ✅ **MAIL_HOST** = `smtp.gmail.com`
6. ✅ **MAIL_PORT** = `587`
7. ✅ **MAIL_ENCRYPTION** = `tls`
8. ✅ **Caché limpiada** después de cambios

### Errores Comunes:

**Error:** "Password not accepted"
- **Solución:** Asegúrate de usar una contraseña de aplicación, NO tu contraseña normal

**Error:** "Verification code required"
- **Solución:** Activa la verificación en 2 pasos primero

**Error:** "Connection timeout"
- **Solución:** Verifica tu conexión a internet y firewall

---

## 🔄 Alternativa: Usar Modo Log (Para Testing)

Si quieres probar sin enviar emails reales, puedes usar:

```env
MAIL_MAILER=log
```

Esto guardará los emails en `storage/logs/laravel.log` en lugar de enviarlos. Útil para desarrollo.

---

## 📚 Enlaces Directos

- **Activar verificación en 2 pasos:** https://myaccount.google.com/security
- **Generar contraseña de aplicación:** https://myaccount.google.com/apppasswords
- **Ayuda de Google:** https://support.google.com/accounts/answer/185833

---

## ✅ Resumen

1. Activa verificación en 2 pasos en Google
2. Genera una contraseña de aplicación (16 caracteres)
3. Actualiza `MAIL_PASSWORD` en `.env` con la contraseña de aplicación
4. Limpia la caché: `php artisan config:clear`
5. Prueba de nuevo

**¡Eso debería solucionar el problema!** 🎉

---

**Fecha**: Diciembre 2024

