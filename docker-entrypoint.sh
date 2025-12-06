#!/bin/bash
# docker-entrypoint.sh - VERSIÓN CORREGIDA

# Usar puerto de Railway si existe, sino 8080
PORT=${PORT:-8080}

echo "🚀 Configurando Apache en puerto ${PORT}..."

# 1. Configurar puerto en Apache ANTES de iniciar
sed -i "s/Listen 8080/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:8080>/<VirtualHost \*:${PORT}>/g" /etc/apache2/sites-available/000-default.conf

# 2. Asegurar permisos
chown -R www-data:www-data /var/www/html
find /var/www/html -type d -exec chmod 755 {} \;
find /var/www/html -type f -exec chmod 644 {} \;

echo "✅ Apache configurado en puerto ${PORT}"
echo "✅ Iniciando Apache..."

# 3. Ejecutar Apache EN PRIMER PLANO
exec apache2-foreground