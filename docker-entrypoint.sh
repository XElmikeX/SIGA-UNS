#!/bin/bash
# docker-entrypoint.sh - VERSIÓN SIMPLIFICADA

# Usar puerto de Railway si existe, sino 8080
PORT=${PORT:-8080}

echo "🚀 Configurando Apache en puerto ${PORT}..."

# Configurar puerto en Apache
sed -i "s/Listen 8080/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:8080>/<VirtualHost \*:${PORT}>/g" /etc/apache2/sites-available/000-default.conf

echo "✅ Apache listo en puerto ${PORT}"

# Ejecutar Apache
exec apache2-foreground