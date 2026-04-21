FROM php:8.1-apache

ENV MYSQL_HOST=db \
    MYSQL_USER=root \
    MYSQL_PASSWORD=root \
    MYSQL_DATABASE=crud_db

RUN docker-php-ext-install mysqli pdo pdo_mysql

# Ativar mod_rewrite
RUN a2enmod rewrite

# Permitir .htaccess
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

COPY ./src /var/www/html/