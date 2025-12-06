# Dockerfile - Asegurar que .htaccess funcione
FROM php:8.4-apache

# Instalar extensiones
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Habilitar módulos
RUN a2enmod rewrite

# Configurar Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Copiar TODO incluyendo .htaccess
COPY . /var/www/html/

# Permisos
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html
RUN find /var/www/html -type f -name ".*" -exec chmod 644 {} \;  # Archivos ocultos

EXPOSE 8080
CMD ["apache2-foreground"]