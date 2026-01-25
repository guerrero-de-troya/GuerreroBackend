# 🚀 Despliegue en Render - Laravel con Docker

## ⚠️ IMPORTANTE: Render ya NO soporta `runtime: php`

Ahora se usa **Docker** obligatoriamente para aplicaciones Laravel.

## 📋 Archivos Configurados

✅ `render.yaml` - Configuración con Docker  
✅ `Dockerfile` - Imagen PHP 8.3 + Apache optimizada  
✅ `.dockerignore` - Excluye archivos innecesarios  

## 🚀 Pasos para Desplegar

### 1. Sube los cambios a Git

```bash
git add .
git commit -m "Configurar Docker para Render"
git push origin main
```

### 2. Crea el Blueprint en Render

1. Ve a [Render Dashboard](https://dashboard.render.com)
2. Click en **"New +"** → **"Blueprint"**
3. Conecta tu repositorio: `guerrero-de-troya/GuerreroBackend`
4. **Branch:** `main`
5. **Blueprint Name:** `Guerrero de Troya`
6. Click en **"Apply"**

Render automáticamente:
- ✅ Crea la base de datos PostgreSQL
- ✅ Construye la imagen Docker
- ✅ Conecta el servicio con la DB
- ✅ Genera `APP_KEY`

### 3. Configurar Variables de Entorno

En el Dashboard → Tu servicio → **Environment**, agrega:

```env
APP_URL=https://tu-servicio.onrender.com
FRONTEND_URL=https://tu-frontend.com
CORS_ALLOWED_ORIGINS=https://tu-frontend.com

# Email (si usas Gmail)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@gmail.com
MAIL_PASSWORD=xxxx xxxx xxxx xxxx  # App Password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@tuapp.com
MAIL_FROM_NAME=Guerrero de Troya
```

### 4. Ejecutar Migraciones (MANUAL - Primera vez)

Una vez desplegado:

1. Ve a tu servicio → **Shell** (menú superior)
2. Ejecuta:

```bash
php artisan migrate --force
php artisan db:seed --force
```

⚠️ **IMPORTANTE:** Las migraciones NO son automáticas para evitar errores en producción.

## 🔧 Configuración del Dockerfile

El Dockerfile incluye:

- **PHP 8.3** con Apache
- **Extensiones:** PDO PostgreSQL, GD, ZIP, MBString, BCMath
- **Composer** para instalar dependencias
- **Optimizaciones:** Config, Route y View caching automáticos
- **Permisos** configurados para `storage/` y `bootstrap/cache/`

## 🐳 Comandos Docker Locales (Opcional)

Para probar localmente con Docker:

```bash
# Construir imagen
docker build -t laravel-app .

# Ejecutar contenedor
docker run -p 8000:80 laravel-app
```

Accede en: `http://localhost:8000`

## 🛠️ Comandos Útiles en Render Shell

```bash
# Ver migraciones
php artisan migrate:status

# Limpiar cachés
php artisan cache:clear
php artisan config:clear

# Ver rutas
php artisan route:list

# Refrescar base de datos (¡CUIDADO!)
php artisan migrate:fresh --seed --force
```

## 🔄 Actualizaciones

Cada push a `main` redespliega automáticamente:

```bash
git add .
git commit -m "Actualización"
git push origin main
```

Render detecta el cambio → Reconstruye Docker → Redespliega.

## 🐛 Solución de Problemas

### Error: "invalid runtime php"
✅ **Solucionado:** Ahora usa `runtime: docker`

### Build falla en Docker
- Revisa logs en Dashboard → Logs
- Verifica que `Dockerfile` esté en la raíz del proyecto
- Asegúrate de que `composer.json` sea válido

### Base de datos no conecta
- Usa las variables `fromDatabase` (ya configuradas)
- NO uses credenciales externas, usa las internas de Render

### Error 500 al acceder
1. Ve a Shell y ejecuta: `php artisan log:tail`
2. Verifica que `APP_KEY` esté configurada
3. Revisa permisos de `storage/`

### Apache no muestra Laravel
- El Dockerfile ya configura `DocumentRoot` a `/public`
- Verifica que Apache esté corriendo: `service apache2 status`

## 📊 Logs

Ver logs en tiempo real:
- Dashboard → Tu servicio → **Logs**

## 💰 Costos

- **Plan Free:**
  - 750 horas/mes (suficiente para 1 proyecto)
  - Base de datos PostgreSQL gratuita (90 días, luego se suspende)
  - Servicio duerme tras 15 min de inactividad

- **Plan Starter ($7/mes):**
  - Sin sleep
  - Base de datos persistente

## ✅ Checklist

- [x] `render.yaml` con Docker
- [x] `Dockerfile` creado
- [x] `.dockerignore` creado
- [ ] Código en Git
- [ ] Blueprint creado en Render
- [ ] Variables de entorno configuradas
- [ ] Migraciones ejecutadas manualmente
- [ ] App funcionando

## 🎉 ¡Tu app estará en:

`https://backend-api.onrender.com`

---

**Nota:** El primer deploy puede tardar 5-10 minutos mientras Docker construye la imagen.
