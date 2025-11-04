# Verificación de Configuración Email - NAWI

## 🔴 Problema Actual

El error indica que Gmail está rechazando las credenciales:
```
Failed to authenticate on SMTP server
Username and Password not accepted
```

El email configurado es: `guillenmariana550@gmail.com`

---

## ✅ Solución: Usar Contraseña de Aplicación

Gmail **NO acepta contraseñas normales** para aplicaciones. Debes usar una **"Contraseña de aplicación"**.

### Pasos para Solucionar:

#### 1. Activar Verificación en 2 Pasos (si no está activada)

1. Ve a: https://myaccount.google.com/security
2. Busca "Verificación en dos pasos"
3. Actívala si no está activada

#### 2. Generar Contraseña de Aplicación

1. Ve a: https://myaccount.google.com/apppasswords
2. Si no aparece, primero activa la verificación en 2 pasos
3. Selecciona:
   - **Aplicación:** Correo
   - **Dispositivo:** Otro (nombre personalizado)
   - **Nombre:** NAWI
4. Haz clic en "Generar"
5. **Copia la contraseña de 16 caracteres** (aparecerá como: `abcd efgh ijkl mnop`)

#### 3. Actualizar archivo .env

Edita tu archivo `.env` y actualiza estas líneas:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=guillenmariana550@gmail.com
MAIL_PASSWORD=abcdefghijklmnop  # ← Pega aquí la contraseña de aplicación (16 caracteres SIN espacios)
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=guillenmariana550@gmail.com
MAIL_FROM_NAME="NAWI"
```

**⚠️ IMPORTANTE:**
- La contraseña de aplicación tiene 16 caracteres
- Si tiene espacios, puedes:
  - Quitarlos: `abcdefghijklmnop`
  - O ponerlos entre comillas: `"abcd efgh ijkl mnop"`

#### 4. Limpiar Caché

Después de actualizar `.env`, ejecuta:

```bash
php artisan config:clear
php artisan cache:clear
```

#### 5. Probar de Nuevo

Intenta solicitar la recuperación de contraseña nuevamente.

---

## 🔍 Verificación de Configuración

Para verificar que todo está correcto, ejecuta:

```bash
php artisan config:show mail.mailers.smtp
```

Deberías ver:
- `username` = `guillenmariana550@gmail.com`
- `password` = (debe estar configurado, no se muestra por seguridad)
- `host` = `smtp.gmail.com`
- `port` = `587`
- `encryption` = `tls`

---

## 📝 Notas Importantes

1. **NUNCA uses tu contraseña normal de Gmail** en aplicaciones
2. **Siempre usa una "Contraseña de aplicación"** para SMTP
3. La contraseña de aplicación es diferente a tu contraseña de Gmail
4. Si cambias tu contraseña de Gmail, la contraseña de aplicación sigue funcionando
5. Puedes tener múltiples contraseñas de aplicación para diferentes servicios

---

## 🆘 Si Aún No Funciona

### Verificar:
1. ¿La verificación en 2 pasos está activada? ✅
2. ¿Generaste la contraseña de aplicación correctamente? ✅
3. ¿Copiaste la contraseña completa (16 caracteres)? ✅
4. ¿Limpiaste la caché después de actualizar `.env`? ✅
5. ¿La contraseña no tiene espacios extra? ✅

### Alternativa: Usar Log para Testing

Si quieres probar sin enviar emails reales, puedes configurar:

```env
MAIL_MAILER=log
```

Esto guardará los emails en `storage/logs/laravel.log` en lugar de enviarlos.

---

## 📚 Enlaces Útiles

- Activar verificación en 2 pasos: https://myaccount.google.com/security
- Generar contraseña de aplicación: https://myaccount.google.com/apppasswords
- Ayuda de Gmail sobre contraseñas de aplicación: https://support.google.com/accounts/answer/185833

---

**Fecha**: Diciembre 2024

