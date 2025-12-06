# Dockerfile para Railway con PHP 8.4 y Apache
FROM php:8.4-apache

# 1. Instalar PostgreSQL support
RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql && \
    apt-get clean

# 2. Habilitar módulos Apache
RUN a2enmod rewrite
RUN a2enmod headers

# 3. Configuración básica de Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# 4. Configurar puerto inicial (será modificado por entrypoint)
RUN sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf
RUN sed -i 's/<VirtualHost \*:80>/<VirtualHost \*:8080>/' /etc/apache2/sites-available/000-default.conf

# 5. Copiar aplicación
COPY . /var/www/html/

# 6. Configurar entrypoint
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# 7. Permisos
RUN chown -R www-data:www-data /var/www/html
RUN find /var/www/html -type d -exec chmod 755 {} \;
RUN find /var/www/html -type f -exec chmod 644 {} \;

# 8. Puerto
EXPOSE 8080

# 9. Entrypoint para puerto dinámico
ENTRYPOINT ["docker-entrypoint.sh"]