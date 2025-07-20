FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libwebp-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    mariadb-client \
    jpegoptim \
    optipng \
    pngquant \
    gifsicle \
    libavif-bin \
    unzip \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    gd \
    exif \
    mbstring \
    zip \
    opcache \
    pcntl \
    bcmath \
    xml


RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin \
    --filename=composer \
    && chmod +x /usr/local/bin/composer


COPY ./conf.d/ /usr/local/etc/php/conf.d/


WORKDIR /var/www
RUN chown -R www-data:www-data /var/www