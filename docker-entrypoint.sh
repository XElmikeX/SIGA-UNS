#!/bin/bash
PORT=${PORT:-8080}
echo "Configurando puerto ${PORT}..."

# Habilitar módulo headers
a2enmod headers

# Configurar ports.conf
sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf

# Configurar ServerName para eliminar warning
echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Configurar sitio por defecto
if [ -f /etc/apache2/sites-available/000-default.conf ]; then
    sed -i "s/<VirtualHost \*:80>/<VirtualHost \*:${PORT}>/g" /etc/apache2/sites-available/000-default.conf
    sed -i "s/<VirtualHost \*:8080>/<VirtualHost \*:${PORT}>/g" /etc/apache2/sites-available/000-default.conf
fi

echo "Iniciando Apache..."
exec apache2-foreground
