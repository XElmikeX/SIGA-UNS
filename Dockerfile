FROM php:8.2-apache

# Instalar PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && a2enmod rewrite

# Configurar Apache para Railway
RUN echo "Listen 8080" > /etc/apache2/ports.conf && \
    echo "<Directory /var/www/html>\nAllowOverride All\nRequire all granted\n</Directory>" > /etc/apache2/conf-available/siga.conf && \
    a2enconf siga

# Copiar aplicación
WORKDIR /var/www/html
COPY . .

# Railway inyecta $PORT, configuramos Apache para usarlo
CMD sed -i "s/Listen 8080/Listen \${PORT}/g" /etc/apache2/ports.conf && \
    sed -i "s/:8080/:\${PORT}/g" /etc/apache2/sites-available/*.conf && \
    apache2-foreground