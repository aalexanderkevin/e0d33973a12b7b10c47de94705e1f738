FROM php:7.3-apache

RUN a2enmod rewrite
WORKDIR /var/www/html
COPY . .

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git

RUN apt-get install -y \
        libzip-dev \
        zip \
  && docker-php-ext-install zip
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install
