FROM dunglas/frankenphp:php8.2.31-bookworm

# Install semua ekstensi PHP yang dibutuhkan termasuk gd
RUN install-php-extensions \
    gd \
    ctype \
    curl \
    dom \
    fileinfo \
    filter \
    hash \
    mbstring \
    openssl \
    pcre \
    pdo \
    pdo_mysql \
    session \
    tokenizer \
    xml \
    zip \
    opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy composer files dulu (supaya Docker cache dependency install)
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev --no-scripts --no-interaction

# Copy seluruh project
COPY . .

# Buat folder yang dibutuhkan Laravel dan beri izin
RUN mkdir -p storage/framework/{sessions,views,cache,testing} storage/logs bootstrap/cache \
    && chmod -R a+rw storage bootstrap/cache

# Buat start script yang jalankan migrate dulu sebelum serve
RUN echo '#!/bin/sh\n\
php artisan config:clear\n\
php artisan migrate --force\n\
php artisan storage:link || true\n\
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8080}' > /start.sh \
    && chmod +x /start.sh

EXPOSE 8000

CMD ["/bin/sh", "/start.sh"]
