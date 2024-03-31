FROM composer as base

COPY . /app

RUN composer install --no-dev --ignore-platform-reqs


FROM dunglas/frankenphp

# Be sure to replace "your-domain-name.example.com" by your domain name
ENV SERVER_NAME=svg.servegame.com
# If you want to disable HTTPS, use this value instead:
#ENV SERVER_NAME=:80

# Enable PHP production settings
#RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY --from=base /app /app

RUN install-php-extensions \
    intl \
    pcntl

#RUN php artisan octane:install --server=frankenphp

CMD ["php", "artisan", "octane:start", "--port=80", "--admin-port=2019"]
