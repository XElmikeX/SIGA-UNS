#!/bin/bash
set -e

# Debug: Mostrar variable PORT
echo "PORT environment variable: $PORT"

# Crear archivo de configuración con el puerto real
echo "Listen $PORT" > /etc/apache2/ports-railway.conf

# Reemplazar ${PORT} en la configuración del virtual host
sed -i "s/\${PORT}/$PORT/g" /etc/apache2/sites-available/000-railway.conf

# Debug: Mostrar configuración
echo "=== Apache Configuration ==="
cat /etc/apache2/ports-railway.conf
echo "=== Virtual Host Configuration ==="
grep -A5 -B5 "VirtualHost" /etc/apache2/sites-available/000-railway.conf

# Ejecutar Apache en primer plano
exec apache2-foreground