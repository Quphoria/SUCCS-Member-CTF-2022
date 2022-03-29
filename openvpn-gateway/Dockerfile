FROM alpine:3.14
RUN apk add --no-cache dos2unix openvpn bind bash

COPY docker-entrypoint.sh /docker-entrypoint.sh
RUN dos2unix /docker-entrypoint.sh

WORKDIR /vpn

# VPN SSL files must be located at /ssl/
# The following files are required:
# - ca.crt
# - dh2048.pem
# - server.crt
# - server.key
# - ta.key

# - /etc/ctf-ssl/:/ssl

COPY config.ovpn /vpn/config.ovpn
COPY bind.conf /etc/bind.conf

EXPOSE 1199

ENTRYPOINT ["bash", "/docker-entrypoint.sh"]