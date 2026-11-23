FROM php:8.5-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends libicu-dev unzip util-linux \
    && docker-php-ext-install -j"$(nproc)" intl pdo_mysql \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html
COPY . .
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --no-interaction --prefer-dist --no-scripts --optimize-autoloader \
    && mkdir -p logs tmp/cache/models tmp/cache/persistent tmp/cache/views tmp/sessions \
    && chown -R www-data:www-data logs tmp

COPY docker/app_local.php config/app_local.php
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf
COPY docker/uploads.ini /usr/local/etc/php/conf.d/studio-spikkel.ini
COPY --chmod=0755 docker/start.sh /usr/local/bin/spikkel-start

CMD ["spikkel-start"]
