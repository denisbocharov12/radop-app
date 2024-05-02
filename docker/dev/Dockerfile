FROM nginx:1.25.2-alpine

ARG UID=1000
ARG GID=1000

RUN apk -U upgrade

RUN apk add --no-cache \
    bash \
    git \
    grep \
    dcron \
    tzdata \
    su-exec \
    shadow \
    openssl \
    supervisor

RUN apk add --no-cache php82 \
    php82-fpm \
    php82-opcache \
    php82-dev \
    php82-gd \
    php82-curl \
    php82-pdo \
    php82-pdo_mysql \
    php82-mysqli \
    php82-mysqlnd \
    php82-mbstring \
    php82-xml \
    php82-zip \
    php82-bcmath \
    php82-soap \
    php82-intl \
    php82-phar \
    php82-json \
    php82-tokenizer \
    php82-dom \
    php82-fileinfo \
    php82-ctype \
    php82-iconv \
    php82-xmlwriter \
    php82-xmlreader \
    php82-simplexml \
    php82-ldap \
    php82-openssl \
    php82-sodium \
    php82-session \
    php82-exif \
    php82-pecl-imagick \
    php82-pecl-xdebug \
    php82-pecl-yaml \
    php82-pecl-memcached \
    php82-pecl-redis \
    php82-pecl-msgpack \
    php82-pecl-igbinary

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
    chmod -R g+rw /var/cache/nginx /var/lib/nginx /var/log/nginx /etc/php82/php-fpm.d && \
    ln -s /usr/bin/php82 /usr/bin/php

COPY docker/common/nginx/php-fpm-pool.conf /etc/php82/php-fpm.d/www.conf
COPY docker/common/nginx/supervisord.conf /etc/supervisor/supervisord.conf
COPY docker/common/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/common/nginx/nginx-site.conf /etc/nginx/conf.d/default.conf

COPY docker/dev/conf/php.ini /etc/php82/conf.d/50-settings.ini
COPY docker/dev/entrypoint.sh /sbin/entrypoint.sh

RUN chmod +x /sbin/entrypoint.sh

COPY --chown=nginx:nginx ../.. .

LABEL "org.opencontainers.image.source"="https://github.com/denisbocharov12/radop-app"

ENTRYPOINT ["/sbin/entrypoint.sh"]

CMD ["true"]
