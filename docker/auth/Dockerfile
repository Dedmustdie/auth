FROM composer:2 as composer_stage

RUN rm -rf /var/www && mkdir -p /var/www/html

WORKDIR /var/www/html

COPY composer.json composer.lock ./

RUN composer install --ignore-platform-reqs --prefer-dist --no-scripts  \
    --no-progress --no-interaction --no-dev --no-autoloader  \
    && composer dump-autoload --optimize --apcu --no-dev

FROM php:8.0.2-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y libpq-dev  \
    && docker-php-ext-install pdo pdo_pgsql pgsql


COPY docker/auth/php.ini /usr/local/etc/php/

COPY --from=composer_stage /var/www/html ${AUTH_VENDOR_PATH}

COPY src src/

CMD ["php-fpm"]