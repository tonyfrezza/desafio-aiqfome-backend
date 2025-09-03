FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    supervisor \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip

RUN pecl install redis \
    && docker-php-ext-enable redis

RUN a2enmod rewrite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY sistema/etc/supervisor/conf.d/laravel-queue.conf /etc/supervisor/conf.d/laravel-queue.conf

WORKDIR /var/www

COPY --chown=www-data:www-data . /var/www

RUN mkdir -p /var/www/storage /var/www/storage/logs /var/www/bootstrap/cache /var/www/public/uploads

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/public/uploads

RUN find /var/www/storage /var/www/bootstrap/cache /var/www/public/uploads -type d -exec chmod 775 {} \; \
    && find /var/www/storage /var/www/bootstrap/cache /var/www/public/uploads -type f -exec chmod 664 {} \;

ENV APACHE_RUN_USER=www-data \
    APACHE_RUN_GROUP=www-data \
    APACHE_DOCUMENT_ROOT=/var/www/ \
    ABSOLUTE_APACHE_DOCUMENT_ROOT=/var/www

ENTRYPOINT ["/bin/bash","-c","chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache && service supervisor start && apache2-foreground"]
