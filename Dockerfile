FROM php:8.2-apache

# Instalar PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean

# Configurar Apache para Railway
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Habilitar módulos
RUN a2enmod rewrite

# Permitir que Apache lea variables de entorno
RUN echo "PassEnv PGHOST PGPORT PGDATABASE PGUSER PGPASSWORD" >> /etc/apache2/apache2.conf

# Copiar aplicación
COPY . /var/www/html/

# Script de inicio para Railway
CMD sed -i "s/80/\$PORT/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf && \
    echo "Apache escuchando en puerto: \$PORT" && \
    apache2-foreground