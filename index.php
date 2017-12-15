<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset='utf-8'>
    <link rel="stylesheet" href="/style/style.css">
  </head>

<!--- Import config.php -------------------> 
<?php require '/var/www/html/config.php'; ?>

<!--- Gona ask block height from http://163.172.143.200:3001 --->
<!--- Define some PHP variables ---------------------------------------------------------------------------------------------->	
<?php
$load = shell_exec("uptime | awk '{print $12}' | sed s/,//g");
$uptime = shell_exec('uptime -p'); # system uptime
$getreportedblock = shell_exec('curl http://163.172.143.200:3001/api/getblockcount'); # asking block height to explorer
$serveraddr = $_SERVER['SERVER_ADDR'];
?>


    <header>

<!--- Show the Banner -------------------> 
<?php include '/var/www/html/banner.php'; ?>

    </header>
  
<body>

<div class="container">
<section id="main_content">

<!--- Define sudo root XIOSd outputs ------------------------------------------------------------------------------------>
<!--- Lets make a big loop for all those nodes ----->
<?php
$howmany = 1;
while ($howmany <= $xios_count)
{

$waitTimeoutInSeconds = 1;
if($fp = fsockopen('localhost',$xios_port,$errCode,$errStr,$waitTimeoutInSeconds)){

    $getreportedblock = shell_exec('curl http://xios.donkeypool.com/api/getblockcount'); # asking block height to explorer
    $getblockcount = shell_exec('sudo /root/xios/src/XIOSd -datadir=/root/.XIOS' . $howmany . ' -config=/root/.XIOS' . $howmany . '/XIOS.conf getblockcount');

	switch (true) {
	  case ($getblockcount>=$getreportedblock):
	   echo '<pre><b><font color=greenyellow>' . $xios_name . '' . $howmany . '</b>@' . $serveraddr . ':' . $xios_port . ' >> ONLINE [SYNCED]</font>';
	  break;
	  case ($getblockcount<$getreportedblock):
	    echo '<pre><b><font color=yellow>' . $xios_name . '' . $howmany . '</b>@' . $serveraddr . ':' . $xios_port . ' >> ONLINE [SYNCING]</font>';
	  break;
	  default:
	    echo '<pre><b><font color=red>' . $xios_name . '' . $howmany . '</b>@' . $serveraddr . ':' . $xios_port . ' >>ONLINE [ERROR]</font>';
	  break;
	}

    $getblockcount = shell_exec("sudo /root/xios/src/XIOSd -datadir=/root/.XIOS" . $howmany . " -config=/root/.XIOS" . $howmany . "/XIOS.conf getblockcount | tr '\n' ' '");
    $getconnectioncount = shell_exec("sudo /root/xios/src/XIOSd -datadir=/root/.XIOS" . $howmany . " -config=/root/.XIOS" . $howmany . "/XIOS.conf getconnectioncount | tr '\n' ' '");
    $staking = shell_exec("sudo /root/xios/src/XIOSd -datadir=/root/.XIOS" . $howmany . " -config=/root/.XIOS" . $howmany . "/XIOS.conf getstakinginfo | grep staking | awk '{print $3}' | sed s/,//g");
    $balance = shell_exec('sudo /root/xios/src/XIOSd -datadir=/root/.XIOS' . $howmany . ' -config=/root/.XIOS' . $howmany . '/XIOS.conf getbalance');
    $getwork = shell_exec('sudo /root/xios/src/XIOSd -datadir=/root/.XIOS' . $howmany . " -config=/root/.XIOS" . $howmany . "/XIOS.conf getwork | grep midstate | awk '{print $3}'");
    $xiosaddress = shell_exec('sudo /root/xios/src/XIOSd -datadir=/root/.XIOS' . $howmany . " -config=/root/.XIOS" . $howmany . "/XIOS.conf getaccountaddress 0");
    $listtx = shell_exec('sudo /root/xios/src/XIOSd -datadir=/root/.XIOS' . $howmany . " -config=/root/.XIOS" . $howmany . "/XIOS.conf listtransactions | egrep 'address|amount|txid|blockindex'");
    echo '</br>Connections : ' . $getconnectioncount . '</br>';
    echo 'Block : ' . $getblockcount . '/ ' . $getreportedblock . ' (node / explorer)</br>';
    echo 'Staking : ' . $staking;
    echo 'Masternode : ' . $masternode . '</br>';
    echo 'Balance : ' . $balance;
    echo 'GetWork : ' . $getwork;
    echo 'Address : ' . $xiosaddress;
    echo 'TX List :</br>' . $listtx . '</pre>';
} else {
	    echo '<pre><b><font color=red>' . $xios_name . '' . $howmany . '</b>@' . $serveraddr . ':' . $xios_port . ' >> OFFLINE</font></pre>';
} 
fclose($fp);
    echo '</p>';
    $howmany++;
    $xios_port++;
}
?>

<?php include "/var/www/html/footer.html";?>
