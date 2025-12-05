FROM php:8.2-apache

# Instalar PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Habilitar rewrite
RUN a2enmod rewrite

# Copiar archivos
COPY . /var/www/html/

# Configuración específica para Railway
# 1. Configurar ServerName para eliminar advertencia
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# 2. Crear script de inicio dinámico
RUN echo '#!/bin/bash\n\
# Usar puerto de Railway\n\
sed -i "s/80/$PORT/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf\n\
echo "Apache escuchando en puerto: $PORT"\n\
exec apache2-foreground' > /usr/local/bin/start.sh

RUN chmod +x /usr/local/bin/start.sh

# Exponer puerto (simbólico, Railway lo maneja)
EXPOSE 8080

CMD ["/usr/local/bin/start.sh"]