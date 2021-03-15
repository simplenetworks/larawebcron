FROM php:7.4.16-fpm



RUN apt-get update && apt-get install -y cron zip libmcrypt-dev\
    mariadb-client nginx curl --no-install-recommends

RUN docker-php-ext-install pdo_mysql

# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . /var/www

RUN composer install  \
    --ignore-platform-reqs \
    --no-autoloader \
    --no-dev \
    --no-ansi \
    --no-interaction

RUN composer dump-autoload --optimize --classmap-authoritative

#Enable opcache
RUN echo "[opcache]\n" \
    "opcache.enable=1\n" \
    "opcache.enable_cli=1\n" \
    "opcache.revalidate_freq=120\n" \
    "opcache.validate_timestamps=1\n" \
    "opcache.max_accelerated_files=10000\n" \
    "opcache.memory_consumption=128\n" \
    "opcache.max_wasted_percentage=10\n" \
    "opcache.interned_strings_buffer=16\n" \
    "opcache.fast_shutdown=1\n" \
    > /usr/local/etc/php/conf.d/opcache.ini 

RUN mkdir -p /etc/nginx/sites-available/

COPY nginx.conf /etc/nginx/sites-enabled/default   

# Copy laravel-cron file to the cron.d directory
COPY larawebcron /etc/cron.d/larawebcron

# Give execution rights on the cron job
RUN chmod 0644 /etc/cron.d/larawebcron

# Apply cron job
RUN crontab /etc/cron.d/larawebcron

RUN chown -R www-data:www-data /var/www


CMD service cron start; service nginx start; php-fpm
