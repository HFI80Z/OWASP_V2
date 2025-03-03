FROM php:8.1-apache

RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Active mod_rewrite (utile pour index.php unique, .htaccess, etc.)
RUN a2enmod rewrite

# Copie TOUT le projet
COPY . /var/www/html
WORKDIR /var/www/html

# On modifie la conf Apache pour pointer sur /var/www/html/public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80
