#!/bin/bash

# write the hosts env variable to the hosts file
rm -f /etc/ctf-hosts

ctf_hosts=$(echo $HOSTS | tr ";" "\n")

for host in $ctf_hosts
do
    ctf_host=$(echo $host | cut -f1 -d:)
    ctf_ip=$(echo $host | cut -f2 -d:)
    echo "$ctf_ip  $ctf_host" >> /etc/ctf-hosts
done

echo "CTF Hosts:"
cat /etc/ctf-hosts

dnsmasq

# Accept DNS requests from vpn
iptables -I INPUT -i tun0 -p udp --dport 53 -j ACCEPT
iptables -I INPUT -i tun0 -p tcp --dport 53 -j ACCEPT

# Enable traffic forwarding from vpn to docker network
iptables -I FORWARD -i tun0 -o eth1 -j ACCEPT
iptables -t nat -A POSTROUTING -s 10.99.0.0/24 -o eth1 -j MASQUERADE

echo "Starting openvpn..."

openvpn --config /vpn/config.ovpn