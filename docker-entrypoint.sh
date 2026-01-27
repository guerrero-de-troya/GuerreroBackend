#!/bin/bash

set -e

echo "Iniciando aplicación Laravel..."

# Esperar a que la base de datos esté lista
echo "Esperando conexión a base de datos..."
until php artisan db:show > /dev/null 2>&1; do
    echo "Base de datos no disponible, reintentando en 2s..."
    sleep 2
done
echo "Base de datos conectada"

# Ejecutar setup de producción si está habilitado
if [ "${AUTO_MIGRATE}" = "true" ] || [ "${RUN_SEEDERS}" = "true" ]; then
    echo " Ejecutando configuración de producción..."
    
    SETUP_ARGS="--force"
    
    if [ "${AUTO_MIGRATE}" = "true" ]; then
        SETUP_ARGS="$SETUP_ARGS --migrate"
    fi
    
    if [ "${RUN_SEEDERS}" = "true" ]; then
        SETUP_ARGS="$SETUP_ARGS --seed"
    fi
    
    php artisan app:setup-production $SETUP_ARGS
    
    if [ $? -eq 0 ]; then
        echo "Setup completado"
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
