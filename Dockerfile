FROM composer as base

COPY . /app

RUN composer install --no-dev --ignore-platform-reqs


FROM dunglas/frankenphp:latest

# Be sure to replace "your-domain-name.example.com" by your domain name
ENV SERVER_NAME=svg.servegame.com
# If you want to disable HTTPS, use this value instead:
#ENV SERVER_NAME=:80

# Enable PHP production settings
#RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY --from=base /app /app

RUN apt update
RUN apt install wget

RUN install-php-extensions \
    intl \
    pcntl \
    gd \
    exif

CMD ["php", "artisan", "octane:start"]
