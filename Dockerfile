FROM composer as base

COPY . /app

RUN composer install --no-dev --ignore-platform-reqs
RUN php artisan migrate --force
RUN php artisan optimize
RUN php artisan optimize:clear
RUN php artisan config:cache
RUN php artisan event:cache
RUN php artisan route:cache
RUN php artisan view:cache


FROM dunglas/frankenphp

# Be sure to replace "your-domain-name.example.com" by your domain name
ENV SERVER_NAME=svg.servegame.com
# If you want to disable HTTPS, use this value instead:
#ENV SERVER_NAME=:80

# Enable PHP production settings
#RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

RUN install-php-extensions \
    intl

COPY --from=base /app /app
