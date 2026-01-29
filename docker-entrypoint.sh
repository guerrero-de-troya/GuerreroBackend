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
    echo " Ejecutando configuración de producción..."
    
    SETUP_ARGS="--force"
    
    if [ "$AUTO_MIGRATE_BOOL" = "true" ]; then
        SETUP_ARGS="$SETUP_ARGS --migrate"
        echo "   ✓ Migraciones habilitadas"
    fi
    
    if [ "$RUN_SEEDERS_BOOL" = "true" ]; then
        SETUP_ARGS="$SETUP_ARGS --seed"
        echo "   ✓ Seeders habilitados"
    fi
    
    php artisan app:setup-production $SETUP_ARGS
    
    if [ $? -eq 0 ]; then
        echo " Setup completado"
    else
        echo " Error en setup"
        exit 1
    fi
else
    echo "Setup automático deshabilitado"
    # Solo optimizar
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

echo "Iniciando servidor Apache..."

exec "$@"
