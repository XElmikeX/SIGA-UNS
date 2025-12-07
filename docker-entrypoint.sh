#!/bin/bash
PORT=${PORT:-8080}
echo "Configurando puerto ${PORT}..."

# SOLUCIÓN CORRECTA para Railway
# 1. Configurar ports.conf
sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf

# 2. Configurar sitio por defecto SIN tocar la línea de VirtualHost
# Encuentra el archivo 000-default.conf y cambia solo el puerto
if [ -f /etc/apache2/sites-available/000-default.conf ]; then
    sed -i "s/<VirtualHost \*:80>/<VirtualHost \*:${PORT}>/g" /etc/apache2/sites-available/000-default.conf
    sed -i "s/<VirtualHost \*:8080>/<VirtualHost \*:${PORT}>/g" /etc/apache2/sites-available/000-default.conf
fi

echo "Iniciando Apache..."
exec apache2-foreground
