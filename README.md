# xios-monitor

PHP script designed to monitor several XIOSd nodes on Ubuntu

# Caution

I DONT WANT YOU TO LOSE YOUR COINS ! 

This is not a secure web app please be carefull with shell_exec command trough apache !

# Requirements

You need XIOSd running on the VPS as root

Then you need http and php server :

<pre>apt-get install apache2 php</pre>

# Install

As root :

<pre>git clone https://github.com/dirtyak/xios-monitor
cp -r ismynodeok/* /var/www/html/.
rm -r ismynodeok
rm -r /var/www/html/index.html</pre>

Permissions

We need to gives sudo perm to www-data to comunicate with XIOSd

So add this line to <b>/etc/sudoers</b>

<pre>www-data ALL=(ALL) NOPASSWD:ALL</pre>

# Config

Please edit config.php to match with your vps parameters

