FROM php:8.3-cli-bookworm AS dev

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        ca-certificates \
        curl \
        gnupg \
        git \
        unzip \
        libsqlite3-dev \
        libzip-dev \
        libicu-dev \
        libonig-dev \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        libwebp-dev \
    && curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y --no-install-recommends nodejs \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install \
        pdo_sqlite \
        zip \
        intl \
        mbstring \
        bcmath \
        exif \
        gd \
    && curl -sS https://getcomposer.org/installer \
        | php -- --install-dir=/usr/local/bin --filename=composer \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY composer.json composer.lock ./

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN composer install \
    --no-interaction \
    --prefer-source \
    --no-progress \
    --no-scripts

COPY package.json package-lock.json ./

RUN npm ci

COPY docker/php/local.ini /usr/local/etc/php/conf.d/99-local.ini
COPY docker/entrypoint.sh /usr/local/bin/entrypoint
COPY docker/dev-start.sh /usr/local/bin/dev-start

RUN chmod +x /usr/local/bin/entrypoint /usr/local/bin/dev-start

ENTRYPOINT ["entrypoint"]
CMD ["dev-start"]

FROM php:8.3-cli-bookworm AS assets

RUN apt-get update \
    && apt-get install -y --no-install-recommends ca-certificates curl gnupg \
    && curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y --no-install-recommends nodejs \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /app

COPY package.json package-lock.json ./

RUN npm ci

COPY vite.config.js ./
COPY resources ./resources
COPY lang ./lang
COPY public ./public

RUN npm run build

FROM php:8.3-cli-bookworm AS vendor

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        ca-certificates \
        curl \
        git \
        unzip \
        libzip-dev \
        libicu-dev \
        libonig-dev \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        libwebp-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install \
        zip \
        intl \
        mbstring \
        exif \
        gd \
    && curl -sS https://getcomposer.org/installer \
        | php -- --install-dir=/usr/local/bin --filename=composer \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --no-scripts \
    --prefer-dist \
    --optimize-autoloader

COPY . .

RUN composer dump-autoload --optimize --classmap-authoritative

FROM php:8.3-fpm-bookworm AS production

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        nginx \
        supervisor \
        sqlite3 \
        libsqlite3-dev \
        libzip-dev \
        libicu-dev \
        libonig-dev \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        libwebp-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install \
        pdo_sqlite \
        zip \
        intl \
        mbstring \
        bcmath \
        exif \
        gd \
        opcache \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY docker/php/local.ini /usr/local/etc/php/conf.d/99-local.ini
COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/100-opcache.ini
COPY docker/nginx/default.conf /etc/nginx/sites-available/default
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint

RUN chmod +x /usr/local/bin/entrypoint \
    && ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default \
    && rm -f /etc/nginx/sites-enabled/default.bak

COPY --from=vendor /app /var/www/html
COPY --from=assets /app/public/build /var/www/html/public/build

RUN mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache database public/images/lum/avatars \
    && touch database/database.sqlite \
    && chown -R www-data:www-data storage bootstrap/cache database public/images/lum

EXPOSE 80

ENTRYPOINT ["entrypoint"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
