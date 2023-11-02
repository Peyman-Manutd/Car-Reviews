FROM php:8-fpm

WORKDIR /var/www

# Install necessary PHP extensions and dependencies
RUN apt-get update && apt-get install -y libpq-dev
RUN docker-php-ext-install pdo pdo_pgsql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Expose port
EXPOSE 9000

CMD ["php-fpm"]
