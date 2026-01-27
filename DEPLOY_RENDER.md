# 🚀 Guía de Deploy en Render

Esta guía explica cómo configurar el deploy automático en Render con migraciones y seeders seguros.

## 📋 Características

- ✅ **Seeders Idempotentes**: No duplican datos, seguros para ejecutar múltiples veces
- ✅ **Migraciones Controladas**: Ejecutar solo cuando sea necesario
- ✅ **Separación de Entornos**: Datos de prueba solo en desarrollo
- ✅ **Usuario Admin Automático**: Se crea al primer deploy
- ✅ **Optimización Automática**: Caché de configuración, rutas y vistas

## 🔧 Configuración en Render

### 1. Build Command

```bash
composer install --optimize-autoloader --no-dev
```

### 2. Start Command

```bash
chmod +x start.sh && ./start.sh
```

### 3. Variables de Entorno Requeridas

#### Configuración de la Aplicación
```env
APP_NAME=TuAplicacion
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-app.onrender.com
FRONTEND_URL=https://tu-frontend.com
```

#### Base de Datos (Render provee estas automáticamente si usas PostgreSQL)
```env
DB_CONNECTION=pgsql
DB_HOST=<render-db-host>
DB_PORT=5432
DB_DATABASE=<render-db-name>
DB_USERNAME=<render-db-user>
DB_PASSWORD=<render-db-password>
```

#### Control de Deploy
```env
# Ejecutar migraciones automáticamente
# Recomendado: false (cambiar a true solo cuando necesites migrar)
AUTO_MIGRATE=false

# Ejecutar seeders automáticamente
# Los seeders son seguros (idempotentes)
RUN_SEEDERS=true

# Crear usuario administrador
CREATE_ADMIN_USER=true
```

#### Credenciales del Administrador
```env
ADMIN_EMAIL=admin@tuempresa.com
ADMIN_PASSWORD=TuPasswordSeguro123!
ADMIN_NOMBRE=Tu
ADMIN_SEGUNDO_NOMBRE=Nombre
ADMIN_APELLIDO=Apellido
ADMIN_SEGUNDO_APELLIDO=Segundo
ADMIN_DOCUMENTO=12345678
ADMIN_TELEFONO=3001234567
```

#### Otras Configuraciones
```env
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
LOG_CHANNEL=stack
```

## 🎯 Estrategia de Deploy

### Primera Vez

1. Configura todas las variables de entorno en Render
2. Establece `AUTO_MIGRATE=true` y `RUN_SEEDERS=true`
3. Haz el primer deploy
4. Verifica que se crearon roles, permisos y usuario admin
5. **Importante**: Cambia la contraseña del admin inmediatamente

### Deploys Posteriores

#### Sin cambios en BD
```env
AUTO_MIGRATE=false
RUN_SEEDERS=true
```
Los seeders son seguros, no duplican datos.

#### Con nuevas migraciones
```env
AUTO_MIGRATE=true
RUN_SEEDERS=true
```
Después del deploy, vuelve a cambiar `AUTO_MIGRATE=false`.

#### Solo actualización de código
```env
AUTO_MIGRATE=false
RUN_SEEDERS=false
```

## 📁 Archivos Creados

### 1. `database/seeders/AdminUserSeeder.php`
Crea el usuario SuperAdministrador usando variables de entorno.

**Características**:
- Idempotente: Solo crea el usuario si no existe
- Usa `firstOrCreate` para evitar duplicados
- Asigna rol SuperAdministrador automáticamente

### 2. `database/seeders/RolePermissionSeeder.php`
Actualizado para ser idempotente.

**Cambios**:
- Usa `syncPermissions` en lugar de `givePermissionTo`
- Resetea caché de permisos en cada ejecución
- No duplica permisos ni roles

### 3. `database/seeders/DatabaseSeeder.php`
Separación entre datos esenciales y de prueba.

**Lógica**:
- Siempre ejecuta seeders esenciales
- Datos de prueba solo en `local` o `development`

### 4. `app/Console/Commands/SetupProductionCommand.php`
Comando artisan para configuración segura.

**Uso**:
```bash
# Ejecutar todo
php artisan app:setup-production --migrate --seed --force

# Solo migraciones
php artisan app:setup-production --migrate --force

# Solo seeders
php artisan app:setup-production --seed --force

# Solo optimización
php artisan app:setup-production --force
```

### 5. `start.sh`
Script de inicio para Render.

**Funciones**:
- Lee variables de entorno
- Ejecuta el comando de setup según configuración
- Optimiza la aplicación
- Inicia el servidor

## 🔐 Seguridad

### ⚠️ Importante

1. **Cambiar contraseña del admin** después del primer deploy
2. Nunca subir `.env` al repositorio
3. Usar contraseñas seguras en producción
4. Revisar logs después de cada deploy

### Roles y Permisos Iniciales

- **usuario**: Permisos básicos de autenticación
- **Administrador**: Permisos de autenticación
- **SuperAdministrador**: Todos los permisos

## 🧪 Probar en Local

### 1. Simular producción
```bash
# .env
APP_ENV=production
AUTO_MIGRATE=true
RUN_SEEDERS=true
CREATE_ADMIN_USER=true
```

### 2. Ejecutar comando
```bash
php artisan app:setup-production --migrate --seed --force
```

### 3. Verificar
```bash
# Ver usuario admin creado
php artisan tinker
>>> User::where('email', env('ADMIN_EMAIL'))->first()

# Ver roles
>>> \Spatie\Permission\Models\Role::all()
```

## 🐛 Troubleshooting

### Error: No se crea el usuario admin
- Verifica que `CREATE_ADMIN_USER=true`
- Revisa que las variables `ADMIN_*` estén configuradas
- Verifica que el seeder se ejecute: `php artisan db:seed --class=AdminUserSeeder`

### Error: Permisos duplicados
- Los seeders ya son idempotentes, esto no debería pasar
- Si ocurre, verifica que uses `syncPermissions` en lugar de `givePermissionTo`

### Error: Migraciones ya ejecutadas
- Normal si `AUTO_MIGRATE=true` en cada deploy
- Laravel detecta automáticamente qué migraciones están pendientes

## 📞 Comandos Útiles

```bash
# Ver estado de migraciones
php artisan migrate:status

# Ejecutar solo seeders de producción
php artisan db:seed --class=RolePermissionSeeder
php artisan db:seed --class=AdminUserSeeder

# Limpiar cachés
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimizar aplicación
php artisan optimize
```

## 🎉 Resultado Esperado

Después del primer deploy deberías tener:

1. ✅ Base de datos migrada
2. ✅ Roles: `usuario`, `Administrador`, `SuperAdministrador`
3. ✅ Permisos de autenticación configurados
4. ✅ Usuario admin con acceso completo
5. ✅ Aplicación optimizada y en ejecución
