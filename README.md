# xios-monitor

PHP script designed to monitor several XIOSd nodes on Ubuntu

# Caution

I DONT WANT YOU TO LOSE YOUR COINS ! 

This is not a secure web app please be carefull with shell_exec command trough apache !

# Requirements

XIOSd compiled in /root/xios/src/

Apache2 and php running :

<pre>apt-get install apache2 php</pre>

# Install

As root :

<pre>git clone https://github.com/dirtyak/xios-monitor
cp -r ismynodeok/* /var/www/html/.
rm -r ismynodeok
rm -r /var/www/html/index.html</pre>

Add www-data to sudoers file for shell_exec function.

<pre>www-data ALL=(ALL) NOPASSWD:ALL</pre>

# Config

Please edit config.php to match with your vps parameters
<pre>$xios_name = "XIOS";       # Name to show for each node
$xios_dir = "/root/.XIOS"; # Directory where config files stored
$xios_ip = localhost;      # XIOSd is running local
$xios_port = 9000;         # port used by first XIOSd
$xios_count = 3;           # How many XIOSd to monitor ?</pre>

In this default config XIOSd ports must be 9000, 9001, 9002 for XIOS1, XIOS2, XIOS3 to work
