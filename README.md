# xios-monitor

PHP script designed to monitor several XIOSd nodes on Ubuntu

# Caution

I DONT WANT YOU TO LOSE YOUR COINS ! 

This is not a secure web app please be carefull with shell_exec command trough apache !

# To Do

Use curl and rpc instead of unsecure "sudo shell_exec" to communicate with XIOSd (working on)

You can control it via the command-line by HTTP JSON-RPC commands.
 
# Requirements

XIOSd compiled in /root/xios/src/

Apache2 and php running :

<pre>apt-get install apache2 php</pre>

# Install

As root :

<pre>cd
git clone https://github.com/dirtyak/xios-monitor
cp -r xios-monitor/* /var/www/html/.
rm -r xios-monitor
rm -r /var/www/html/index.html</pre>

Add www-data to sudoers file for shell_exec function.
<pre>nano /etc/sudoers</pre>
Add this line :
<pre>www-data ALL=(ALL) NOPASSWD:ALL</pre>
Save it

# Config

Please edit config.php to match with your vps parameters
<pre>$xios_name = "XIOS";       # Name to show for each node
$xios_ip = localhost;      # XIOSd is running local
$xios_port = 9000;         # port used by first XIOSd
$xios_count = 3;           # How many XIOSd to monitor ?</pre>

In this default config XIOSd ports must be 9000, 9001, 9002 for XIOS1, XIOS2, XIOS3 to work

# Example 

You can try it at : http://45.77.53.110/

Hosted by Vultr : https://www.vultr.com/?ref=7280492

# Fix 

If you already setup your wallet in ".XIOS", copy it to ".XIOS1".

<b>As root</b> :

<pre>/root/src/xios/XIOSd stop
cd
cp -r $HOME/.XIOS/ $HOME/.XIOS1</pre>

Now use this script to get your node(s) online :

<pre>/root/xios/src/XIOSd -datadir=/root/.XIOS1 -config=/root/.XIOS1/XIOS.conf -daemon
#/root/xios/src/XIOSd -datadir=/root/.XIOS2 -config=/root/.XIOS2/XIOS.conf -daemon
#/root/xios/src/XIOSd -datadir=/root/.XIOS3 -config=/root/.XIOS3/XIOS.conf -daemon
#...
#Uncomment according your configuration
</pre>
