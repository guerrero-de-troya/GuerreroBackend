#!/usr/bin/env bash

set -o errexit

echo "Iniciando proceso de build..."

# Instalar dependencias de Composer
echo "Instalando dependencias de Composer..."
composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Limpiar cachés anteriores
echo " Limpiando cachés..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Optimizar para producción
echo "Optimizando aplicación para producción..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Creando enlace simbólico para storage..."
php artisan storage:link

echo "Configurando permisos..."
chmod -R 775 storage bootstrap/cache

echo "Build completado exitosamente!"