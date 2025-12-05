FROM php:8.2-apache

# Instalar extensiones PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Habilitar módulos Apache
RUN a2enmod rewrite

# Copiar archivos de la aplicación
COPY . /var/www/html/

# Configurar Apache para Railway
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Crear archivo de configuración para puerto dinámico
RUN echo "Listen \${PORT}" > /etc/apache2/ports-railway.conf
RUN echo "IncludeOptional ports-railway.conf" >> /etc/apache2/apache2.conf

# Configurar virtual host para Railway
RUN echo '<VirtualHost *:${PORT}>\n\
    ServerName localhost\n\
    DocumentRoot /var/www/html\n\
    <Directory /var/www/html>\n\
        Options Indexes FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
    ErrorLog \${APACHE_LOG_DIR}/error.log\n\
    CustomLog \${APACHE_LOG_DIR}/access.log combined\n\
</VirtualHost>' > /etc/apache2/sites-available/000-railway.conf

# Habilitar sitio de Railway
RUN a2dissite 000-default
RUN a2ensite 000-railway

# Script de inicio para Railway
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE ${PORT}

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]