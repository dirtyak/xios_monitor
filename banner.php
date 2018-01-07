<?php
echo '<center><div class="ascii-art">';
echo "<a href=http://$serveraddr></br>";
echo "<b><font color=#8A084B>╔════════════════════════════════╗</b></font></br>";
echo "<b><font color=#8A084B>║   #   #   #    ####     #####  ║</b></font></br>";
echo "<b><font color=#B4045F>║    # #    #   #    #   #       ║</b></font></br>";
echo "<b><font color=#DF0174>║     #     #   #    #    ####   ║</b></font></br>";
echo "<b><font color=#FF0080>║    # #    #   #    #        #  ║</b></font></br>";
echo "<b><font color=#FE2E9A>║   #   #   #    ####    #####   ║</b></font></br>";
echo "<b><font color=#FE2E9A>╚════════════════════════════════╝</b></font></br>";
echo "<b>XIOS-MONITOR</b>@" . $serveraddr . "</a></br>";
echo "$uptime";
echo "Load average : <a>$load</a>";

if(ctype_alnum($getreportedblock)){
echo '<a target="_blank" href=http://' . $xios_explorer . '>Explorer</a> reported Block Height : <a>' . $getreportedblock . '</a></br>';
}else{ echo "ERROR WITH EXPLORER PLEASE CHECK config.php";}

echo "Monitoring <a>$xios_count</a> nodes :";
echo '</div>';
echo '</center>';
?>
