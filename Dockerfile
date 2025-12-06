FROM php:8.3-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

COPY . /var/www
RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /var/www

EXPOSE 9000

CMD ["php-fpm"]
