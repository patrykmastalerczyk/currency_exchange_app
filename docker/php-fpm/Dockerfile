FROM php:8.2.0-fpm
WORKDIR "/application"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

ENV TZ=Europe/Warsaw
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

COPY ./docker/php-fpm/php-ini-overrides.ini /usr/local/etc/php/conf.d/docker-php.ini

RUN apt-get update && apt-get install -y \
        libicu-dev \
        libzip-dev \
        zip

COPY --from=composer:2.4 /usr/bin/composer /usr/local/bin/composer

RUN docker-php-ext-install zip intl pdo_mysql