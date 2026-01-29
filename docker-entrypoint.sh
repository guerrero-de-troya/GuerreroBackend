#!/bin/bash

set -e

echo " Iniciando aplicación Laravel..."

# Función para generar APP_KEY válida
generate_app_key() {
    if command -v openssl > /dev/null 2>&1; then
        openssl rand -base64 32 | tr -d '\n'
    else
        # Usar PHP como alternativa si openssl no está disponible
        php -r "echo base64_encode(random_bytes(32));"
    fi
}

# Validar y generar APP_KEY si es necesario
echo " Verificando APP_KEY..."
APP_KEY_VALID=false

if [ -z "${APP_KEY}" ] || [ "${APP_KEY}" = "null" ] || [ "${APP_KEY}" = "" ]; then
    echo "  APP_KEY no está configurada, generando nueva clave..."
    NEW_KEY=$(generate_app_key)
    if [ -n "${NEW_KEY}" ] && [ ${#NEW_KEY} -ge 32 ]; then
        export APP_KEY="base64:${NEW_KEY}"
        echo " APP_KEY generada exitosamente"
        APP_KEY_VALID=true
    else
        echo " Error al generar APP_KEY, intentando con Laravel..."
        # Último recurso: usar Laravel para generar la clave (puede fallar si Laravel no puede inicializarse)
        if php artisan key:generate --show > /tmp/app_key.txt 2>&1; then
            export APP_KEY=$(cat /tmp/app_key.txt | tr -d '\n')
            rm -f /tmp/app_key.txt
            echo " APP_KEY generada usando Laravel"
            APP_KEY_VALID=true
        else
            echo " Error crítico: No se pudo generar APP_KEY. La aplicación puede no funcionar correctamente."
            APP_KEY_VALID=false
        fi
    fi
elif [[ ! "${APP_KEY}" =~ ^base64: ]]; then
    echo "  APP_KEY no está en formato correcto (debe comenzar con 'base64:'), intentando corregir..."
    # Si la clave existe pero no está en formato base64, intentar convertirla o regenerarla
    if [ ${#APP_KEY} -eq 32 ]; then
        # Si tiene exactamente 32 caracteres, codificarla en base64
        ENCODED=$(echo -n "${APP_KEY}" | base64 -w 0 2>/dev/null || echo -n "${APP_KEY}" | base64)
        if [ -n "${ENCODED}" ]; then
            export APP_KEY="base64:${ENCODED}"
            echo "APP_KEY convertida a formato base64"
            APP_KEY_VALID=true
        else
            echo "  No se pudo convertir, regenerando..."
            NEW_KEY=$(generate_app_key)
            if [ -n "${NEW_KEY}" ]; then
                export APP_KEY="base64:${NEW_KEY}"
                echo " APP_KEY regenerada en formato correcto"
                APP_KEY_VALID=true
            fi
        fi
    else
        # Regenerar completamente
        NEW_KEY=$(generate_app_key)
        if [ -n "${NEW_KEY}" ]; then
            export APP_KEY="base64:${NEW_KEY}"
            echo "APP_KEY regenerada en formato correcto"
            APP_KEY_VALID=true
        fi
    fi
else
    # Verificar que la clave tenga la longitud correcta (base64 de 32 bytes = 44 caracteres + prefijo "base64:")
    KEY_LENGTH=${#APP_KEY}
    if [ $KEY_LENGTH -lt 50 ]; then
        echo "⚠️  APP_KEY parece tener longitud incorrecta (${KEY_LENGTH} caracteres), regenerando..."
        NEW_KEY=$(generate_app_key)
        if [ -n "${NEW_KEY}" ]; then
            export APP_KEY="base64:${NEW_KEY}"
            echo " APP_KEY regenerada con longitud correcta"
            APP_KEY_VALID=true
        fi
    else
        echo " APP_KEY válida detectada (${KEY_LENGTH} caracteres)"
        APP_KEY_VALID=true
    fi
fi

if [ "$APP_KEY_VALID" = false ]; then
    echo " ADVERTENCIA: APP_KEY no pudo ser validada o generada correctamente."
    echo "   La aplicación puede fallar al iniciar. Verifica las variables de entorno en Render."
fi

# Mostrar variables de conexión para debug
echo " Variables de conexión:"
if [ -n "${DATABASE_URL}" ]; then
    echo "   DATABASE_URL: ${DATABASE_URL:0:50}..." # Mostrar solo primeros 50 caracteres por seguridad
else
    echo "   DATABASE_URL: (no configurada)"
fi
echo "   DB_CONNECTION: ${DB_CONNECTION:-no configurada}"
echo "   DB_HOST: ${DB_HOST:-no configurada}"
echo "   DB_PORT: ${DB_PORT:-no configurada}"
echo "   DB_DATABASE: ${DB_DATABASE:-no configurada}"
echo "   DB_USERNAME: ${DB_USERNAME:-no configurada}"

# Función para verificar conexión a la base de datos
check_db_connection() {
    # Intentar con db:show primero (más rápido)
    if php artisan db:show > /dev/null 2>&1; then
        return 0
    fi
    
    # Si falla, intentar una consulta simple
    if php artisan tinker --execute="DB::connection()->getPdo();" > /dev/null 2>&1; then
        return 0
    fi
    
    return 1
}

# Test de conectividad básico
echo ""
echo " Probando conectividad..."
if [ -n "${DB_HOST}" ] && command -v pg_isready > /dev/null 2>&1; then
    echo "   Intentando pg_isready..."
    pg_isready -h "${DB_HOST}" -p "${DB_PORT:-5432}" -U "${DB_USERNAME}" -t 2 || echo "   pg_isready falló, continuando con verificación Laravel..."
else
    echo "   pg_isready no disponible o DB_HOST no configurado, usando verificación Laravel..."
fi

# Esperar a que la base de datos esté lista (con timeout)
echo ""
echo " Esperando conexión a base de datos..."
MAX_TRIES=15
COUNTER=0
DB_CONNECTED=false

while [ $COUNTER -lt $MAX_TRIES ]; do
    COUNTER=$((COUNTER + 1))
    
    if check_db_connection; then
        echo " Base de datos conectada exitosamente"
        DB_CONNECTED=true
        break
    fi
    
    echo "Base de datos no disponible, reintentando en 2s... (intento $COUNTER/$MAX_TRIES)"
    sleep 2
done

if [ "$DB_CONNECTED" = false ]; then
    echo " No se pudo conectar a la base de datos después de ${MAX_TRIES} intentos"
    echo ""
    echo "Diagnóstico:"
    echo "  - Verifica en Render Dashboard que la base de datos 'backend-guerrero' esté creada y en estado 'Available'"
    echo "  - Verifica que las variables de entorno DB_* o DATABASE_URL estén configuradas correctamente"
    echo "  - Verifica que el servicio de base de datos esté en la misma región que el servicio web"
    echo ""
    echo "  Continuando sin ejecutar migraciones/seeders..."
    echo "  La aplicación puede no funcionar correctamente sin conexión a la base de datos"
    echo ""
    
    # NO cachear configuración si la BD no está disponible para evitar problemas
    echo " Optimizando aplicación sin BD (sin cache de configuración)..."
    php artisan route:cache || true
    php artisan view:cache || true
    echo " Iniciando servidor Apache..."
    exec "$@"
    exit 0
fi

# Normalizar variables de entorno
AUTO_MIGRATE_BOOL="${AUTO_MIGRATE:-false}"
RUN_SEEDERS_BOOL="${RUN_SEEDERS:-false}"

echo " Configuración:"
echo "   AUTO_MIGRATE: $AUTO_MIGRATE_BOOL"
echo "   RUN_SEEDERS: $RUN_SEEDERS_BOOL"

# Ejecutar setup de producción si está habilitado
if [ "$AUTO_MIGRATE_BOOL" = "true" ] || [ "$RUN_SEEDERS_BOOL" = "true" ]; then
    echo "Ejecutando configuración de producción..."
    
    # Ejecutar migraciones si está habilitado
    if [ "$AUTO_MIGRATE_BOOL" = "true" ]; then
        echo " Ejecutando migraciones..."
        if php artisan migrate --force; then
            echo " Migraciones completadas exitosamente"
        else
            echo " Error al ejecutar migraciones"
            echo "   Verifica los logs anteriores para más detalles"
            exit 1
        fi
    fi
    
    # Ejecutar seeders si está habilitado
    if [ "$RUN_SEEDERS_BOOL" = "true" ]; then
        echo " Ejecutando seeders..."
        if php artisan db:seed --force; then
            echo " Seeders completados exitosamente"
        else
            echo " Error al ejecutar seeders"
            echo "   Verifica los logs anteriores para más detalles"
            exit 1
        fi
    fi
    
    # Optimizar aplicación
    echo " Optimizando aplicación..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    echo " Optimización completada"
    
else
    echo " Setup automático deshabilitado"
    # Solo optimizar
    echo " Optimizando aplicación..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    echo " Optimización completada"
fi

echo "Iniciando servidor Apache..."

exec "$@"
