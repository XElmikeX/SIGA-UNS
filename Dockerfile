FROM php:8.2-apache

# Instalar extensiones de PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Habilitar módulos de Apache
RUN a2enmod rewrite
RUN a2enmod headers

# Copiar archivos de la aplicación
COPY . /var/www/html/
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Configurar Apache para que use el puerto de Railway
RUN sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf
RUN sed -i 's/:80/:8080/' /etc/apache2/sites-available/*.conf

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Puerto expuesto (Railway usa 8080 por defecto)
EXPOSE 8080

# Comando de inicio simple
CMD ["apache2-foreground"]