#!/bin/bash

# named -c /etc/bind.conf -4 -f -d 99 &
named -c /etc/bind.conf -4 -f &

# Accept DNS requests from vpn
iptables -I INPUT -i tun0 -p udp --dport 53 -j ACCEPT
iptables -I INPUT -i tun0 -p tcp --dport 53 -j ACCEPT

# Enable traffic forwarding from vpn to docker network
iptables -I FORWARD -i tun0 -o eth1 -j ACCEPT
iptables -t nat -A POSTROUTING -s 10.99.0.0/24 -o eth1 -j MASQUERADE

echo "Starting openvpn..."

openvpn --config /vpn/config.ovpn