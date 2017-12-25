<?php
echo '<center><div class="ascii-art">';
echo "<a href=http://$serveraddr></br>";
echo "<b><font color=#8A084B>__________________________________</b></font></br>";
echo "<b><font color=#8A084B>|   #   #   #    ####     #####   </b>|</font></br>";
echo "<b><font color=#B4045F>|    # #    #   #    #   #        </b>|</font></br>";
echo "<b><font color=#DF0174>|     #     #   #    #    ####    </b>|</font></br>";
echo "<b><font color=#FF0080>|    # #    #   #    #        #   </b>|</font></br>";
echo "<b><font color=#FE2E9A>|<u>   #   #   #    ####    #####    </u></b>|</font></br>";
echo "<b>XIOS-MONITOR</b>@" . $serveraddr ."</a></br>";
echo "$uptime";
echo "Load average : $load";
echo "Monitoring <a>$xios_count</a> nodes :";
echo '</div>';
echo '</center>';
?>
