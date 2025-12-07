FROM php:8.2-apache

# Instalar extensiones de PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Habilitar módulos de Apache
RUN a2enmod rewrite

# Configurar Apache ANTES de copiar archivos
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN echo "Listen 8080" > /etc/apache2/ports.conf
RUN echo "Listen 8080" >> /etc/apache2/ports.conf

# Configurar VirtualHost para puerto 8080
RUN echo '<VirtualHost *:8080>' > /etc/apache2/sites-available/000-default.conf
RUN echo '    ServerAdmin webmaster@localhost' >> /etc/apache2/sites-available/000-default.conf
RUN echo '    DocumentRoot /var/www/html' >> /etc/apache2/sites-available/000-default.conf
RUN echo '    ErrorLog ${APACHE_LOG_DIR}/error.log' >> /etc/apache2/sites-available/000-default.conf
RUN echo '    CustomLog ${APACHE_LOG_DIR}/access.log combined' >> /etc/apache2/sites-available/000-default.conf
RUN echo '    <Directory /var/www/html>' >> /etc/apache2/sites-available/000-default.conf
RUN echo '        Options Indexes FollowSymLinks' >> /etc/apache2/sites-available/000-default.conf
RUN echo '        AllowOverride All' >> /etc/apache2/sites-available/000-default.conf
RUN echo '        Require all granted' >> /etc/apache2/sites-available/000-default.conf
RUN echo '    </Directory>' >> /etc/apache2/sites-available/000-default.conf
RUN echo '</VirtualHost>' >> /etc/apache2/sites-available/000-default.conf

# Deshabilitar sitio por defecto en puerto 80
RUN a2dissite 000-default.conf
# Habilitar nuestro sitio en puerto 8080
RUN a2ensite 000-default.conf

# Copiar archivos de la aplicación
COPY . /var/www/html/

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html

# Puerto expuesto
EXPOSE 8080

# Comando simple
CMD ["apache2-foreground"]