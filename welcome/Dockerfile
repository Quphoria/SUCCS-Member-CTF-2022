FROM alpine:3.14
RUN apk add --no-cache dos2unix apache2

COPY docker-entrypoint.sh /docker-entrypoint.sh
RUN dos2unix /docker-entrypoint.sh

WORKDIR /var/www/html

COPY httpd.conf /etc/apache2/httpd.conf

COPY chall/ .

EXPOSE 80

ENTRYPOINT ["/docker-entrypoint.sh"]