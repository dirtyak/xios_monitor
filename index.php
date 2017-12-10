<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset='utf-8'>
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <link rel="stylesheet" href="/style/style.css">
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" sizes="180x180" href="/style/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/style/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/style/favicon-16x16.png">
    <link rel="mask-icon" href="/style/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">
  </head>

<!--- Import config.php ------------------->
<?php require '/var/www/html/config.php'; ?>

<!--- Gona ask block height from http://163.172.143.200:3001 --->
<!--- Define some PHP variables ---------------------------------------------------------------------------------------------->	
<?php
$load = shell_exec("uptime | awk '{print $11}' | sed s/,//g");
$uptime = shell_exec('uptime -p'); # system uptime
$getreportedblock = shell_exec('curl http://163.172.143.200:3001/api/getblockcount'); # asking block height to explorer
$lastblocks = shell_exec("tail -n 2 history.html | sed s/,//g | awk -F ',' '{print $1}' | tr '\n' ' ' | awk '{print $2 - $1}'");
$serveraddr = $_SERVER['SERVER_ADDR'];
?>

  <body>
    <header>
      <div class="container">

<?php echo "<a><h1>XIOS-MONITOR@" . $serveraddr ."</h1></a>"?>

<!------------- Menu --------------------!>
<?php include "/var/www/html/navbar.php";?>

</div></header>
<div class="container">
<section id="main_content">

<!--- Define sudo root XIOSd outputs ------------------------------------------------------------------------------------>	
<!--- Lets make a big loop for all those nodes ----->
<?php
$howmany = 1;
while ($howmany <= 3)
{

$waitTimeoutInSeconds = 1; 
if($fp = fsockopen('localhost',$xios_port,$errCode,$errStr,$waitTimeoutInSeconds)){   
	    echo '<p> <font color=greenyellow>XIOS' . $howmmany . '@' . $serveraddr . ':' . $xios_port . ' >> ONLINE</font></b><br />';
} else {
	    echo '<p> <font color=red>XIOS_' . $howmmany . '@' . $serveraddr . ':' . $xios_port . ' >> OFFLINE</font></b><br />';
} 
fclose($fp);

    $getblockcount = shell_exec('sudo /root/xios/src/XIOSd -datadir=/root/.XIOS' . $howmany . ' -config=/root/.XIOS' . $howmany . '/XIOS.conf getblockcount');
    $getconnectioncount = shell_exec('sudo /root/xios/src/XIOSd -datadir=/root/.XIOS' . $howmany . ' -config=/root/.XIOS' . $howmany . '/XIOS.conf getconnectioncount');
    $staking = shell_exec("sudo /root/xios/src/XIOSd -datadir=/root/.XIOS" . $howmany . " -config=/root/.XIOS" . $howmany . "/XIOS.conf getstakinginfo | grep staking | awk '{print $3}' | sed s/,//g");
    $balance = shell_exec('sudo /root/xios/src/XIOSd -datadir=/root/.XIOS' . $howmany . ' -config=/root/.XIOS' . $howmany . '/XIOS.conf getbalance');
    $getwork = shell_exec('sudo /root/xios/src/XIOSd -datadir=/root/.XIOS' . $howmany . ' -config=/root/.XIOS' . $howmany . '/XIOS.conf getwork');
    echo 'Connections : ' . $getconnectioncount . ' | Block height (node/explorer) : ' . $getblockcount .' / ' . $getreportedblock . ' | Staking : ' . $staking . ' | Balance : ' . $balance .'';
    echo '</p>';
    $howmany++;
    $xios_port++;
}
?>



<?php include "/var/www/html/footer.php";?>
