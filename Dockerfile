FROM php:8.1-fpm

RUN apt update && apt upgrade -y && apt install -y curl telnet 

RUN apt install -y libzip-dev zip

RUN docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
    && docker-php-ext-install mysqli pdo pdo_mysql zip

COPY ./events /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install --no-interaction

CMD ["php", "artisan", "serve"]