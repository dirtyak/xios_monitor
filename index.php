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
$load = shell_exec("uptime | awk '{print $8}' | sed s/,//g");
$uptime = shell_exec('uptime -p'); # system uptime
$getreportedblock = shell_exec('curl http://163.172.143.200:3001/api/getblockcount'); # asking block height to explorer
$lastblocks = shell_exec("tail -n 2 history.html | sed s/,//g | awk -F ',' '{print $1}' | tr '\n' ' ' | awk '{print $2 - $1}'");
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
	    echo '<p> <font color=greenyellow>' . $xios_name . '' . $howmany . '@' . $serveraddr . ':' . $xios_port . ' >> ONLINE</font></b><br />';
} else {
	    echo '<p> <font color=red>' . $xios_name . '' . $howmany . '@' . $serveraddr . ':' . $xios_port . ' >> OFFLINE</font></b><br />';
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
