FROM php:8.1-apache

# Instalar extensiones necesarias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Activar módulos de Apache (opcional si usas .htaccess)
RUN a2enmod rewrite

# Copiar archivos del proyecto al contenedor
COPY . /var/www/html