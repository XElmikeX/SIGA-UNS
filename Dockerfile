FROM php:8.2-apache

# Instalar PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean

# Configurar Apache para Railway
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN a2enmod rewrite

# Permitir variables de entorno en Apache
RUN echo "PassEnv PGHOST PGPORT PGDATABASE PGUSER PGPASSWORD" >> /etc/apache2/apache2.conf

# Copiar aplicación
COPY . /var/www/html/

# Comando de inicio DIRECTO para Railway
CMD apache2-foreground -DFOREGROUND -e info