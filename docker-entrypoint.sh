#!/bin/bash
PORT=${PORT:-8080}
echo "Configurando puerto ${PORT}..."
sed -i "s/Listen 8080/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:8080>/<VirtualHost \*:${PORT}>/g" /etc/apache2/sites-available/000-default.conf
echo "Iniciando Apache..."
exec apache2-foreground
