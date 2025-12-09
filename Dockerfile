FROM php:8.2-apache

# Instalar extensiones PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Habilitar mod_rewrite para URLs amigables
RUN a2enmod rewrite

# Copiar archivos
COPY . /var/www/html/

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod +x /var/www/html/docker-entrypoint.sh

# Puerto expuesto
EXPOSE 8080

# Punto de entrada
ENTRYPOINT ["/var/www/html/docker-entrypoint.sh"]