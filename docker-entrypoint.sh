#!/bin/bash
# Configurar puerto dinámico
PORT=${PORT:-8080}
echo "🚀 Configurando puerto ${PORT}..."

# Configurar Apache para usar el puerto dinámico
sed -i "s/Listen 8080/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/:8080/:${PORT}/g" /etc/apache2/sites-available/000-default.conf

# Configurar ServerName para evitar warnings
echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Iniciar Apache
echo "🚀 Iniciando Apache..."
exec apache2-foreground
