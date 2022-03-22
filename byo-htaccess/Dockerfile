FROM alpine:3.14
RUN apk add --no-cache apache2 php7-apache2 php7-session

COPY docker-entrypoint.sh /docker-entrypoint.sh

WORKDIR /var/www/html

COPY httpd.conf /etc/apache2/httpd.conf

COPY chall/ .

COPY flag.txt /flag

RUN chmod 777 /var/www/html/uploads

EXPOSE 80

ENTRYPOINT ["/docker-entrypoint.sh"]