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

  <body>
    <header>
      <div class="container">

<?php echo "<h1><a>XIOS-MONITOR@" . $serveraddr ."</a> $uptime</h1>"?>
<?php echo "<h2>CPU load : " . $load . "| Monitoring " . $xios_count . " nodes :</h2>"?>

<!------------- Menu --------------------!>
<?php include "/var/www/html/navbar.php";?>

</div></header>
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

    $getreportedblock = shell_exec('curl http://163.172.143.200:3001/api/getblockcount'); # asking block height to explorer
    $getblockcount = shell_exec('sudo /root/xios/src/XIOSd -datadir=/root/.XIOS' . $howmany . ' -config=/root/.XIOS' . $howmany . '/XIOS.conf getblockcount');

	switch (true) {
	  case ($getblockcount>=$getreportedblock):
	   echo '<p> <font color=greenyellow>' . $xios_name . '' . $howmany . '@' . $serveraddr . ':' . $xios_port . ' >> ONLINE [SYNCED]</font><br />';
	  break;
	  case ($getblockcount<$getreportedblock):
	    echo '<p> <font color=yellow>' . $xios_name . '' . $howmany . '@' . $serveraddr . ':' . $xios_port . ' >> ONLINE [SYNCING]</font><br />';
	  break;
	  default:
	    echo '<p> <font color=red>' . $xios_name . '' . $howmany . '@' . $serveraddr . ':' . $xios_port . ' >>ONLINE [ERROR]</font><br />';
	  break;
	}

    $getblockcount = shell_exec('sudo /root/xios/src/XIOSd -datadir=/root/.XIOS' . $howmany . ' -config=/root/.XIOS' . $howmany . '/XIOS.conf getblockcount');
    $getconnectioncount = shell_exec('sudo /root/xios/src/XIOSd -datadir=/root/.XIOS' . $howmany . ' -config=/root/.XIOS' . $howmany . '/XIOS.conf getconnectioncount');
    $staking = shell_exec("sudo /root/xios/src/XIOSd -datadir=/root/.XIOS" . $howmany . " -config=/root/.XIOS" . $howmany . "/XIOS.conf getstakinginfo | grep staking | awk '{print $3}' | sed s/,//g");
    $balance = shell_exec('sudo /root/xios/src/XIOSd -datadir=/root/.XIOS' . $howmany . ' -config=/root/.XIOS' . $howmany . '/XIOS.conf getbalance');
    $getwork = shell_exec('sudo /root/xios/src/XIOSd -datadir=/root/.XIOS' . $howmany . " -config=/root/.XIOS" . $howmany . "/XIOS.conf getwork | grep midstate | awk '{print $3}'");
    $xiosaddress = shell_exec('sudo /root/xios/src/XIOSd -datadir=/root/.XIOS' . $howmany . " -config=/root/.XIOS" . $howmany . "/XIOS.conf getaccountaddress 0");
    echo 'Connections : ' . $getconnectioncount . '</br>';
    echo 'Block : ' . $getblockcount . '/ ' . $getreportedblock . ' (node / explorer)</br>';
    echo 'Staking : ' . $staking . '</br>'; 
    echo 'Balance : ' . $balance . '</br>';
    echo 'GetWork : ' . $getwork . '</br>';
    echo 'Address : ' . $xiosaddress . '(New Address Generated on Receive)</br>';
} else {
	    echo '<p> <font color=red>' . $xios_name . '' . $howmany . '@' . $serveraddr . ':' . $xios_port . ' >> OFFLINE</font></b><br />';
} 
fclose($fp);
    echo '</p>';
    $howmany++;
    $xios_port++;
}
?>


<?php include "/var/www/html/footer.html";?>
