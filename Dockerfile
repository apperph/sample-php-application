FROM php:8.1-cli-alpine3.15

WORKDIR /var/www

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY . .

RUN docker-php-ext-install \
    pdo \
    pdo_mysql

RUN composer install

ENTRYPOINT ["bin/start-development-server.sh"]
