FROM php:8.3-fpm-alpine

WORKDIR /var/www/

ARG TZ='UTC'

RUN echo "${TZ}" && apk --update add tzdata && \
    cp /usr/share/zoneinfo/$TZ /etc/localtime && \
    echo $TZ > /etc/timezone && \
    apk del tzdata
