FROM php:fpm-alpine

ARG PHPUSER
ARG PHPGROUP

ENV PHPGROUP=${PHPGROUP}
ENV PHPUSER=${PHPUSER}

RUN adduser -g ${PHPGROUP} -s /bin/sh -D ${PHPUSER}; exit 0

WORKDIR /var/www

RUN sed -i "s/user = www-data/user = ${PHPUSER}/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = ${PHPGROUP}/g" /usr/local/etc/php-fpm.d/www.conf

RUN apk add build-base py-pip jpeg-dev zlib-dev libpng-dev libjpeg-turbo-dev libwebp-dev freetype-dev
RUN apk add jpegoptim optipng pngquant gifsicle
RUN apk add autoconf gcc g++ make && pecl install redis && docker-php-ext-enable redis
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype
RUN docker-php-ext-install gd

RUN apk add ffmpeg

COPY ./custom.ini /usr/local/etc/php/conf.d/custom.ini

RUN chown -R ${PHPUSER}:${PHPGROUP} /var/www
RUN chmod 755 /var/www

# RUN mkdir -p /usr/src/php/ext/redis \
#     && curl -L https://github.com/phpredis/phpredis/archive/5.3.4.tar.gz | tar xvz -C /usr/src/php/ext/redis --strip 1 \
#     && echo 'redis' >> /usr/src/php-available-exts \
#     && docker-php-ext-install redis

