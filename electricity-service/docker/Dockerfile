FROM php:8.3-fpm
WORKDIR /var/www/html
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libicu-dev \
    libzip-dev \
    && docker-php-ext-install \
    intl \
    pdo_mysql \
    zip
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY .. .
EXPOSE 9000
CMD bash -c "composer install --no-scripts --no-interaction && php-fpm"
