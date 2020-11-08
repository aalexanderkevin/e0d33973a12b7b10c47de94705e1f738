FROM php:latest

RUN apt-get update

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git
RUN apt-get install -y libpq-dev \
  && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
  && docker-php-ext-install pdo pdo_pgsql pgsql

WORKDIR /worker
COPY . .

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --prefer-dist

CMD [ "php", "worker.php" ]

