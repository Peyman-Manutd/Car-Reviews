FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    git \
    zlib1g-dev \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# Install composer.
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install --no-scripts --no-autoloader --prefer-dist --no-dev --working-dir=/app &

WORKDIR /app

COPY . /app

RUN bin/console assets:install public

COPY ./migrations /app/migrations

EXPOSE 9000

CMD ["php-fpm"]