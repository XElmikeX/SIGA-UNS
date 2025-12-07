#!/bin/bash
# docker-entrypoint.sh - VERSIÓN SUPER SIMPLE
PORT=${PORT:-8080}
echo "Usando puerto: ${PORT}"

# Configurar Apache para usar el puerto dinámico
sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT}/g" /etc/apache2/sites-available/*.conf

# Iniciar Apache
echo "🚀 Iniciando Apache..."
exec apache2-foreground