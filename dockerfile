# 1. Usar una imagen oficial de PHP 8.2 con Apache
FROM php:8.2-apache

# 2. Instalar la extensión pdo_mysql para que PHP hable con la BD
RUN docker-php-ext-install pdo_mysql

# 3. Habilitar mod_rewrite de Apache (para URLs bonitas si se necesita)
RUN a2enmod rewrite

# 4. Establecer el directorio raíz del servidor
# (Esta es la corrección que hicimos para que coincida con tus rutas)
WORKDIR /var/www/html/proyectos/finanzas-dentidesk

# 5. Copiar todo tu proyecto (backend y frontend) al contenedor
# (Ajustamos para copiar a la subcarpeta correcta)
COPY ./backend ./backend
COPY ./frontend ./frontend