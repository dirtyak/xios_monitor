<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset='utf-8'>
    <link rel="stylesheet" href="/style/style.css">
  </head>

<!--- Import config.php -------------------> 
<?php require '/var/www/html/config.php'; ?>

<!--- Define some PHP variables ---------------------------------------------------------------------------------------------->	
<?php
$load = shell_exec("uptime | grep -ohe 'load average[s:][: ].*' | awk '{ print $3 $4 $5 }'");
$uptime = shell_exec('uptime -p'); # system uptime
$serveraddr = $_SERVER['SERVER_ADDR'];
$getreportedblock = shell_exec('curl ' . $xios_explorer . '/api/getblockcount'); # asking block height to explorer
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

echo '<div class="floating-box">';

    $getblockcount = shell_exec('sudo /root/xios/src/XIOSd -datadir=/root/.XIOS' . $howmany . ' -config=/root/.XIOS' . $howmany . '/XIOS.conf getblockcount');
    settype($getreportedblock, "integer");
    settype($getblockcount, "integer");

	switch (true) {
	  case ($getblockcount>=$getreportedblock):
	    echo '<pre class="online"><b><font color=greenyellow>' . $xios_name . '' . $howmany . '</b>@' . $serveraddr . ':' . $xios_port . ' >> ONLINE [SYNCED]</font>';
	  break;
	  case ($getblockcount<$getreportedblock):
	    echo '<pre class="syncing"><b><font color=orange>' . $xios_name . '' . $howmany . '</b>@' . $serveraddr . ':' . $xios_port . ' >> ONLINE [SYNCING]</font>';
	  break;
	  default:
	    echo '<pre class="offline"><b><font color=red>' . $xios_name . '' . $howmany . '</b>@' . $serveraddr . ':' . $xios_port . ' >>ONLINE [ERROR]</font>';
	  break;
	}

    $getblockcount = shell_exec("sudo /root/xios/src/XIOSd -datadir=/root/.XIOS" . $howmany . " -config=/root/.XIOS" . $howmany . "/XIOS.conf getblockcount | tr '\n' ' '");
    //$getconnectioncount = shell_exec("sudo /root/xios/src/XIOSd -datadir=/root/.XIOS" . $howmany . " -config=/root/.XIOS" . $howmany . "/XIOS.conf getconnectioncount | tr '\n' ' '");
    $xiosaddress = shell_exec('sudo /root/xios/src/XIOSd -datadir=/root/.XIOS' . $howmany . " -config=/root/.XIOS" . $howmany . "/XIOS.conf listtransactions 0 1000| grep -B5 generated | grep address | awk '{print $3}' | grep -oe '[-0-9a-zA-Z]*' | tail -n 1");
    $xiosaddress0 = shell_exec('sudo /root/xios/src/XIOSd -datadir=/root/.XIOS' . $howmany . " -config=/root/.XIOS" . $howmany . "/XIOS.conf getaccountaddress 0");
    $getinfo = shell_exec('sudo /root/xios/src/XIOSd -datadir=/root/.XIOS' . $howmany . " -config=/root/.XIOS" . $howmany . "/XIOS.conf getinfo | grep -E '\"balance|blocks|connection'");
    $mngetinfo = shell_exec('sudo /root/xios/src/XIOSd -datadir=/root/.XIOS' . $howmany . " -config=/root/.XIOS" . $howmany . "/XIOS.conf masternode status| grep status");
    $stakinginfo = shell_exec('sudo /root/xios/src/XIOSd -datadir=/root/.XIOS' . $howmany . " -config=/root/.XIOS" . $howmany . "/XIOS.conf getstakinginfo|grep -E staking\|enabled");
    $received = shell_exec('sudo /root/xios/src/XIOSd -datadir=/root/.XIOS' . $howmany . " -config=/root/.XIOS" . $howmany . "/XIOS.conf listtransactions 0 10000|grep generate| wc -l");
    //$txid = shell_exec('sudo /root/xios/src/XIOSd -datadir=/root/.XIOS' . $howmany . ' -config=/root/.XIOS' . $howmany . "/XIOS.conf listtransactions 0 1000| grep -A7 1000 | grep txid | awk '{print $3}' | grep -oe '[-0-9a-zA-Z]*'");
    //$index = shell_exec('sudo /root/xios/src/XIOSd -datadir=/root/.XIOS' . $howmany . ' -config=/root/.XIOS' . $howmany . "/XIOS.conf gettransaction da6998fc00ad6c0f341dfda1142fd6a1a4ccf65ceefe07d1ec561c2e0bd8119d | grep -A1 1000 | grep n | grep -E '1|0'");
    //$listtx = shell_exec('sudo /root/xios/src/XIOSd -datadir=/root/.XIOS' . $howmany . " -config=/root/.XIOS" . $howmany . "/XIOS.conf listtransactions | grep -E 'generated'");


if (isset($xiosaddress)) {
    echo '</br>ADDR(R) : <a target="_blank" href=http://' . $xios_explorer . '/address/' . $xiosaddress . '>' . $xiosaddress . '</a>';
} else {
    echo '</br>ADDR(0) : <a target="_blank" href=http://' . $xios_explorer . '/address/' . $xiosaddress0 . '>' . $xiosaddress0 . '</a>';
}

    //echo '</br>TXID : </br><font size="1"><a href=http://xios.donkeypool.com/tx/' . $txid . '>' . $txid . '</a></font>';
    //echo '</br>INDEX : ' . $index . '</a>';

    echo '</br>GETINFO : </br>' . $getinfo . '';
    echo '</br>MASTERNODE STATUS : </br>' . $mngetinfo . '';
    echo '</br>STAKING : </br>' . $stakinginfo . '';
    echo '</br>RECEIVED : ' . $received . '</pre>';
} else {
    echo '<div class="floating-box">';
    echo '<pre class="offline"><b><font color=red>' . $xios_name . '' . $howmany . '</b>@' . $serveraddr . ':' . $xios_port . ' >> OFFLINE</font></pre>';
}
fclose($fp);
    echo '</div>';
    $howmany++;
    $xios_port++;
}
?>

<?php include "/var/www/html/footer.html";?>
