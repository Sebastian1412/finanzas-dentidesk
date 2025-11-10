# 1. Usar una imagen oficial de PHP 8.2 con Apache
FROM php:8.2-apache

# 2. Instalar la extensión pdo_mysql para que PHP hable con la BD
RUN docker-php-ext-install pdo_mysql

# 3. Habilitar mod_rewrite de Apache 
RUN a2enmod rewrite

WORKDIR /var/www/html/proyectos/finanzas-dentidesk

COPY ./backend ./backend
COPY ./frontend ./frontend