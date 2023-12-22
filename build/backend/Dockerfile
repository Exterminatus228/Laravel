FROM php:8.2-fpm
WORKDIR /app
COPY . .
RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev libxml++2.6-dev libpng++-dev git zip git
RUN docker-php-ext-install \
    gd intl pdo pdo_mysql
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer
RUN pecl install xdebug-3.3.1 && docker-php-ext-enable xdebug
COPY ./xdebug.ini /usr/local/etc/php/conf.d
ENTRYPOINT ["./build/backend/entrypoint.sh"]
