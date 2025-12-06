# Dockerfile para Railway con PHP 8.4 y Apache - VERSIÓN CORREGIDA
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

# 4. Copiar entrypoint PRIMERO para configurar puerto dinámico
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# 5. Configurar Apache para puerto dinámico EN EL ENTRYPOINT
#    (NO configurar puerto fijo aquí)

# 6. Copiar aplicación
COPY . /var/www/html/

# 7. Permisos
RUN chown -R www-data:www-data /var/www/html
RUN find /var/www/html -type d -exec chmod 755 {} \;
RUN find /var/www/html -type f -exec chmod 644 {} \;

# 8. Puerto (Railway manejará el puerto)
EXPOSE 8080

# 9. Entrypoint para puerto dinámico - AHORA SÍ se ejecuta ANTES de Apache
ENTRYPOINT ["docker-entrypoint.sh"]