FROM php:7.4-fpm-alpine

# Setup working directory
WORKDIR /var/www

RUN apk add --no-cache openssl bash mysql-client nodejs npm alpine-sdk autoconf  vim
RUN set -ex \
  && apk --no-cache add \
    postgresql-dev
RUN docker-php-ext-install pdo pdo_pgsql


# Prepare log files
RUN touch /var/log/cron.log


# Crontab
COPY schedule /etc/cron.d
RUN chmod -R 644 /etc/cron.d
RUN crontab /etc/cron.d/schedule

CMD ["crond", "-f"]


