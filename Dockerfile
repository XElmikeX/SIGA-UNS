# Dockerfile - VERSIÓN SIMPLIFICADA
FROM php:8.4-apache

# 1. Instalar PostgreSQL
RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql && \
    apt-get clean

# 2. Habilitar módulos
RUN a2enmod rewrite
RUN a2enmod headers

# 3. Configurar Apache para usar puerto dinámico
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# 4. Configurar para puerto dinámico (Railway proveerá PORT)
RUN sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf
RUN sed -i 's/<VirtualHost \*:80>/<VirtualHost \*:8080>/' /etc/apache2/sites-available/000-default.conf

# 5. Script para puerto dinámico
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# 6. Copiar aplicación
COPY . /var/www/html/

# 7. Permisos
RUN chown -R www-data:www-data /var/www/html
RUN find /var/www/html -type d -exec chmod 755 {} \;
RUN find /var/www/html -type f -exec chmod 644 {} \;

# 8. Puerto
EXPOSE 8080

# 9. Usar shell para que las variables de entorno se expandan
CMD ["sh", "-c", "sed -i \"s/Listen 8080/Listen ${PORT:-8080}/g\" /etc/apache2/ports.conf && sed -i \"s/<VirtualHost \\*:8080>/<VirtualHost \\*:${PORT:-8080}>/g\" /etc/apache2/sites-available/000-default.conf && exec apache2-foreground"]