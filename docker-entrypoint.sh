#!/bin/bash
set -e

# Reemplazar $PORT con el valor real
sed -i "s/\${PORT}/${PORT}/g" /etc/apache2/ports.conf
sed -i "s/\${PORT}/${PORT}/g" /etc/apache2/sites-available/000-railway.conf

# Ejecutar comando principal
exec "$@"