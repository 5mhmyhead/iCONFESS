FROM php:8.4-cli

RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN apt-get update && apt-get install -y unzip git \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader

EXPOSE 8080

ARG CACHEBUST=1
CMD ["sh", "-c", "echo PORT is: $PORT && php -S 0.0.0.0:$PORT -t public"]