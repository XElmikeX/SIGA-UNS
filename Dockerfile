FROM php:8.4-apache

# Instalar dependencias para PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean

# Habilitar módulos Apache
FROM php:8.4-apache

# Instalar dependencias para PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean

# Habilitar módulos Apache
RUN a2enmod rewrite headers

# Configurar Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf && \
    sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Preconfigurar para puerto 8080 (será cambiado por el entrypoint)
RUN sed -i "s/Listen 80/Listen 8080/g" /etc/apache2/ports.conf && \
    sed -i "s/<VirtualHost \*:80>/<VirtualHost \*:8080>/g" /etc/apache2/sites-available/000-default.conf

# Copiar archivos
COPY . /var/www/html/

# Copiar y dar permisos al entrypoint
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Permisos
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Puerto
EXPOSE 8080

# Usar entrypoint
ENTRYPOINT ["docker-entrypoint.sh"]