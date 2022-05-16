FROM php:8-fpm

RUN apt-get update \
    && docker-php-ext-install -j$(nproc) \
    mysqli \
    pdo_mysql

COPY php.ini /usr/local/etc/php/conf.d/custom-config.ini

WORKDIR /var/www/html

CMD ["php-fpm"]
CMD ["php console.php"]
