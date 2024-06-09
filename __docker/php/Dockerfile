FROM php:8.2-fpm-alpine

WORKDIR /var/www/spammer

RUN apk update && apk add \
    bash \
    curl \
    nodejs \
    npm
RUN docker-php-ext-install pdo pdo_mysql

RUN rm -rf /var/cache/apk/* && docker-php-source delete

RUN addgroup --gid 1000 --system www && \
    adduser --uid 1000 --system www --ingroup www

USER www

EXPOSE 9000

CMD ["php-fpm"]