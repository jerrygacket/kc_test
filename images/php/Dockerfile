FROM php:8-fpm

RUN apt-get update \
    && docker-php-ext-install -j$(nproc) \
    mysqli \
    pdo_mysql \
    php-cli

COPY php.ini /usr/local/etc/php/conf.d/custom-config.ini

WORKDIR /var/www/html

CMD ["php-fpm"]
ENTRYPOINT ["/usr/bin/php","-f","/var/www/html/console.php"]
