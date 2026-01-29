#!/bin/bash

set -e

echo " Iniciando aplicación Laravel..."

# Mostrar variables de conexión para debug
echo " Variables de conexión:"
echo "   DB_CONNECTION: ${DB_CONNECTION}"
echo "   DB_HOST: ${DB_HOST}"
echo "   DB_PORT: ${DB_PORT}"
echo "   DB_DATABASE: ${DB_DATABASE}"
echo "   DB_USERNAME: ${DB_USERNAME}"

# Test de conectividad básico
echo ""
echo " Probando conectividad..."
if command -v pg_isready > /dev/null 2>&1; then
    pg_isready -h "${DB_HOST}" -p "${DB_PORT}" -U "${DB_USERNAME}" || true
else
    echo "   pg_isready no disponible, intentando conexión directa..."
fi

# Esperar a que la base de datos esté lista (con timeout)
echo ""
echo "⏳ Esperando conexión a base de datos..."
MAX_TRIES=15
COUNTER=0

until php artisan db:show > /dev/null 2>&1; do
    COUNTER=$((COUNTER + 1))
    
    if [ $COUNTER -gt $MAX_TRIES ]; then
        echo "  No se pudo conectar a la base de datos después de ${MAX_TRIES} intentos"
        echo " Continuando sin ejecutar migraciones/seeders..."
        echo " Verifica en Render Dashboard que la base de datos 'backend-guerrero' esté creada y en estado 'Available'"
        break
    fi
    
    echo "Base de datos no disponible, reintentando en 2s... (intento $COUNTER/$MAX_TRIES)"
    sleep 2
done

if [ $COUNTER -le $MAX_TRIES ]; then
    echo "Base de datos conectada"
else
    # Si no hay BD, solo optimizar y continuar
    echo " Optimizando aplicación sin BD..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
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
        echo "Ejecutando migraciones..."
        php artisan migrate --force
        
        if [ $? -eq 0 ]; then
            echo "Migraciones completadas"
        else
            echo "Error en migraciones"
            exit 1
        fi
    fi
    
    # Ejecutar seeders si está habilitado
    if [ "$RUN_SEEDERS_BOOL" = "true" ]; then
        echo "Ejecutando seeders..."
        php artisan db:seed --force
        
        if [ $? -eq 0 ]; then
            echo "Seeders completados"
        else
            echo " Error en seeders"
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
    echo "Setup automático deshabilitado"
    # Solo optimizar
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

echo "Iniciando servidor Apache..."

exec "$@"
