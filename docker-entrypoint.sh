#!/bin/bash

set -e

echo "Iniciando aplicación Laravel..."

# Esperar a que la base de datos esté lista
echo "Esperando conexión a base de datos..."
until php artisan db:show > /dev/null 2>&1; do
    echo "Base de datos no disponible, reintentando en 2s..."
    sleep 2
done
echo " Base de datos conectada"

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
