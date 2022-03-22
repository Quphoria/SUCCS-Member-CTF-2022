FROM alpine:3.14
RUN apk add --no-cache apache2 php7-apache2 composer git

COPY docker-entrypoint.sh /docker-entrypoint.sh

WORKDIR /var/www/html

COPY httpd.conf /etc/apache2/httpd.conf

COPY chall/ .

COPY flag.txt /flag
COPY jwt_secret.txt /jwt_secret

RUN cd php && composer require firebase/php-jwt

EXPOSE 80

ENTRYPOINT ["/docker-entrypoint.sh"]