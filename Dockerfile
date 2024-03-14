# syntax=docker/dockerfile:1
FROM mysql
ADD ./src/dbscripts/user-sql-dump.sql /docker-entrypoint-initdb.d

FROM php:8.2-apache as base
RUN a2enmod rewrite
CMD ["apache2-foreground"]
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
RUN composer self-update 2.6.6 \
RUN composer install \

FROM base as development
COPY ./tests /var/www/html/tests
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN a2enmod rewrite
RUN service apache2 restart

