FROM php:8.2-fpm-alpine3.17

ARG APP_ENV
RUN apk add --no-cache git

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions zip bcmath @composer; \
    rm /usr/local/bin/install-php-extensions;

WORKDIR /app
EXPOSE 80

CMD ["php", "-S", "0.0.0.0:80", "-t", "public"]
