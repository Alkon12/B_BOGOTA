
FROM php:8.1-apache

# Instalar extensiones de PHP necesarias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Activar módulos de Apache necesarios
RUN a2enmod rewrite && a2enmod php8.1

# Configurar Apache para interpretar archivos PHP
RUN echo "<FilesMatch \\.php$>\n\
    SetHandler application/x-httpd-php\n\
</FilesMatch>" > /etc/apache2/conf-available/php-handler.conf \
    && a2enconf php-handler

# Cambiar Apache para escuchar en el puerto 8080 (importante para Railway)
RUN sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf \
    && sed -i 's/:80/:8080/' /etc/apache2/sites-available/000-default.conf

# Ajustar permisos para asegurar que Apache pueda ejecutar archivos PHP
COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Exponer el puerto correcto
EXPOSE 8080

# Iniciar Apache
CMD ["apache2-foreground"]

