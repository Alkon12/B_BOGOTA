FROM php:8.1-apache

# Instalar extensiones necesarias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Activar módulos de Apache (opcional si usas .htaccess)
RUN a2enmod rewrite

RUN echo "<FilesMatch \\.php$>\n\
    SetHandler application/x-httpd-php\n\
</FilesMatch>" > /etc/apache2/conf-enabled/php-handler.conf

RUN docker-php-ext-enable mysqli pdo pdo_mysql && \
    echo "<FilesMatch \\.php$>\n\
    SetHandler application/x-httpd-php\n\
    </FilesMatch>" > /etc/apache2/conf-enabled/php-handler.conf
# Copiar archivos del proyecto al contenedor
COPY . /var/www/html
# Ajustar permisos de Apache y archivos PHP
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html


RUN sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf \
    && sed -i 's/:80/:8080/' /etc/apache2/sites-available/000-default.conf
