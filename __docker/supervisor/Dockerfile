FROM php:8.2-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql

RUN apk update && apk add supervisor

WORKDIR /var/www/spammer

CMD ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisor/supervisord.conf"]