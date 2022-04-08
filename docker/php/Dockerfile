FROM php:8.1.4-fpm
RUN sed -i 's#\(deb\|security\).debian.org#mirrors.aliyun.com#g' /etc/apt/sources.list \
    && apt-get update -y && apt-get upgrade -y \
    && apt-get install -y --no-install-recommends \
    	cron \
        wait-for-it \
        imagemagick \
        netpbm \
        libjpeg-dev \
        libpng-dev \
        libfreetype6-dev \
        imagemagick \
        netpbm \
    	libzip-dev \
    && apt-get clean -y && apt-get autoclean -y && apt-get autoremove -y \
    && docker-php-ext-configure gd \
        && docker-php-ext-install -j $(nproc) gd \
    && docker-php-ext-configure exif \
        && docker-php-ext-install -j $(nproc) exif \
    && docker-php-ext-configure zip \
        && docker-php-ext-install -j $(nproc) zip  \
    && docker-php-ext-configure bcmath \
        && docker-php-ext-install -j $(nproc) bcmath  \
    && docker-php-ext-configure pdo_mysql \
        && docker-php-ext-install -j $(nproc) pdo_mysql
RUN curl https://mirrors.aliyun.com/composer/composer.phar -o /bin/composer \
    && chmod +x /bin/composer
COPY php.ini /usr/local/etc/php/php.ini
WORKDIR /var/www
