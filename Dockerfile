FROM debian:bookworm-slim

# Instalar Apache, PHP y extensiones PostgreSQL
RUN apt-get update && apt-get install -y \
    apache2 \
    libapache2-mod-php \
    php-pgsql \
    curl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Crear directorio de la aplicación
WORKDIR /var/www/html

# Copiar TODOS los archivos de tu proyecto
COPY . .

# Configurar Apache para Railway
RUN echo "Listen \${PORT}" > /etc/apache2/ports.conf

# Crear virtual host para Railway
RUN echo "<VirtualHost *:\${PORT}>\n\
    ServerName localhost\n\
    DocumentRoot /var/www/html\n\
    <Directory /var/www/html>\n\
        Options Indexes FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
    ErrorLog \${APACHE_LOG_DIR}/error.log\n\
    CustomLog \${APACHE_LOG_DIR}/access.log combined\n\
</VirtualHost>" > /etc/apache2/sites-available/000-railway.conf

# Habilitar módulos y sitio
RUN a2enmod rewrite && \
    a2dissite 000-default && \
    a2ensite 000-railway

# Exponer puerto dinámico
EXPOSE ${PORT}

# Script de inicio que reemplaza $PORT
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]