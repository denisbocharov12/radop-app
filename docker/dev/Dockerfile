FROM nginx:1.23.0-alpine

ARG UID=1000
ARG GID=1000

RUN apk -U upgrade

RUN apk add --no-cache \
    bash \
    git \
    grep \
    dcron \
    shadow \
    openssl \
    supervisor

RUN apk add --no-cache \
    php81 \
    php81-fpm \
    php81-opcache \
    php81-dev \
    php81-gd \
    php81-curl \
    php81-pdo \
    php81-pdo_mysql \
    php81-mysqli \
    php81-mysqlnd \
    php81-mbstring \
    php81-xml \
    php81-zip \
    php81-bcmath \
    php81-soap \
    php81-intl \
    php81-phar \
    php81-json \
    php81-tokenizer \
    php81-dom \
    php81-fileinfo \
    php81-ctype \
    php81-iconv \
    php81-xmlwriter \
    php81-xmlreader \
    php81-simplexml \
    php81-ldap \
    php81-pecl-imagick \
    php81-openssl \
    php81-sodium \
    php81-session \
    php81-pecl-yaml \
    php81-pecl-memcached \
    php81-pecl-redis \
    php81-pecl-msgpack \
    php81-pecl-igbinary \
    php81-exif \
    php81-intl

RUN usermod -u ${UID} nginx && groupmod -g ${GID} nginx

RUN echo "UTC" > /etc/timezone && \
    cp /usr/share/zoneinfo/UTC /etc/localtime

WORKDIR /var/www/html/

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN mkdir -p /var/www/html && \
    mkdir -p /var/cache/nginx && \
    mkdir -p /var/lib/nginx && \
    mkdir -p /var/log/nginx && \
    touch /var/log/nginx/access.log && \
    touch /var/log/nginx/error.log && \
    chown -R nginx:nginx /var/cache/nginx /var/lib/nginx /var/log/nginx && \
    chmod -R g+rw /var/cache/nginx /var/lib/nginx /var/log/nginx /etc/php81/php-fpm.d && \
    ln -s /usr/bin/php81 /usr/bin/php

COPY docker/common/nginx/php-fpm-pool.conf /etc/php81/php-fpm.d/www.conf
COPY docker/common/nginx/supervisord.conf /etc/supervisor/supervisord.conf
COPY docker/common/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/common/nginx/nginx-site.conf /etc/nginx/conf.d/default.conf

COPY docker/dev/conf/php.ini /etc/php81/conf.d/50-settings.ini
COPY docker/dev/entrypoint.sh /sbin/entrypoint.sh

RUN chmod +x /sbin/entrypoint.sh

COPY --chown=nginx:nginx ../.. .

LABEL "org.opencontainers.image.source"="https://github.com/denisbocharov12/radop-app"

ENTRYPOINT ["/sbin/entrypoint.sh"]

CMD ["true"]
