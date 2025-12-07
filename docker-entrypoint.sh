#!/bin/bash
# docker-entrypoint.sh - VERSIÓN MÍNIMA FUNCIONAL
PORT=${PORT:-8080}
echo "Iniciando en puerto ${PORT}"

# Solo configurar puerto - nada más
sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf

# Iniciar Apache
exec apache2-foreground