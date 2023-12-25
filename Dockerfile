FROM php:8.1.1-alpine
# Setup working directory
WORKDIR /var/www
COPY core/ .
RUN apk add openssl \
    bash\
    nodejs\
    npm\
    alpine-sdk\
    autoconf\
    gd\
    libzip-dev \
     nginx\
    supervisor\
    wget\
    git\
    procps\
    less\
    libpng libpng-dev libjpeg-turbo-dev libwebp-dev zlib-dev libxpm-dev libsodium-dev



RUN cd / &&  git clone --branch v4.8.11 https://github.com/swoole/swoole-src.git \
    && ( \
        cd swoole-src \
        && phpize \
        && ./configure --enable-swoole-debug --enable-mysqlnd \
        && make -j$(nproc) && make install \
        ) \
    && rm -r /swoole-src \
    && docker-php-ext-enable swoole \
    && rm -rf /var/cache/apk/*
RUN rm -rf /var/cache/apk/*


RUN set -ex \
  && apk  add \
    postgresql-dev \
    imagemagick-dev

RUN docker-php-ext-install pdo pdo_pgsql  bcmath  zip  gd


RUN docker-php-ext-configure pcntl --enable-pcntl \
  && docker-php-ext-install gd \
    pcntl

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis


RUN docker-php-ext-install sockets

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer skipcache

# Run composer update
RUN composer update --no-interaction --no-scripts


# Copy php/supervisor configs
COPY .docker/supervisor/app.conf /etc/supervisord.conf
RUN true
COPY .docker/php/php.ini /usr/local/etc/php/conf.d/app.ini
RUN true




RUN mkdir /var/log/php
RUN touch /var/log/php/errors.log && chmod 777 /var/log/php/errors.log

RUN composer global require "squizlabs/php_codesniffer=*"

COPY entrypoint.sh /tmp/entrypoint.sh
RUN true
COPY fix-permission /bin/
RUN true


RUN rm -rf /var/cache/apk/*
RUN chmod 777 -R /tmp && chmod o+t -R /tmp

# Prepare log files for cron
RUN touch /var/log/cron.log
# Crontab
COPY .docker/cron/schedule /etc/cron.d
RUN chmod -R 644 /etc/cron.d
RUN crontab /etc/cron.d/schedule
CMD ["crond", "-f"]

EXPOSE 80
CMD ["/bin/fix-permission", "-f"]
ENTRYPOINT ["/tmp/entrypoint.sh"]
