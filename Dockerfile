# Dockerfile
FROM php:8.3-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libzip-dev zip unzip curl libpq-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mysqli

# Apache Konfiguration
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Aktivieren von Apache mod_rewrite
RUN a2enmod rewrite

# Set working dir
WORKDIR /var/www/html
