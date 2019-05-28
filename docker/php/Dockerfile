FROM composer as backend
WORKDIR /var/www/app

COPY ./src/composer.json ./src/composer.lock /var/www/app/
RUN composer install  \
  --ignore-platform-reqs \
  --no-ansi \
  --no-autoloader \
  --no-dev \
  --no-interaction \
  --no-scripts

COPY ./src /var/www/app
COPY ./src/.env.example /var/www/app/.env
RUN composer dump-autoload --optimize --classmap-authoritative
RUN ls -l

FROM php:7.3-fpm as base

RUN apt-get update && \
  apt-get install -y --no-install-recommends \
  curl \
  libmemcached-dev \
  libz-dev \
  libpq-dev \
  libjpeg-dev \
  libpng-dev\
  libfreetype6-dev \
  libssl-dev \
  libmcrypt-dev \
  unzip \
  wget \
  libsodium-dev

FROM base as build

RUN apt-get install -y libmcrypt-dev \ 
  && docker-php-ext-install sodium \
  && docker-php-ext-install mysqli \
  && docker-php-ext-install pdo_mysql \
  && docker-php-ext-install pdo_pgsql \
  && docker-php-ext-install gd \
  && docker-php-ext-configure gd \
  --enable-gd-native-ttf \
  --with-jpeg-dir=/usr/lib \
  --with-freetype-dir=/usr/include/freetype2 \
  && docker-php-ext-install gd \
  && rm -r /var/lib/apt/lists/*

COPY ./docker/php/lumen.ini /usr/local/etc/php/conf.d
COPY ./docker/php/lumen.pool.conf /usr/local/etc/php-fpm.d/

FROM build as app

WORKDIR /var/www/app

COPY --from=backend /var/www/app /var/www/app

RUN ls -l vendor
RUN chmod u+x artisan

CMD ["php-fpm"]

EXPOSE 9000