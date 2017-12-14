<?php
echo '<div class="ascii-art">';
echo "<b><font color=#8A084B> _________________________________</b></font></br>";
echo "<b><font color=#8A084B>|   #   #   #    ####     #####   </b>|</font>   <a href=http://$serveraddr><b>XIOS-MONITOR</b>@" . $serveraddr ."</a></br>";
echo "<b><font color=#B4045F>|    # #    #   #    #   #        </b>|</font>   $uptime";
echo "<b><font color=#DF0174>|     #     #   #    #    ####    </b>|</font>  </br>";
echo "<b><font color=#FF0080>|    # #    #   #    #        #   </b>|</font>   CPU load : $load";
echo "<b><font color=#FE2E9A>|<u>   #   #   #    ####    #####    </u></b>|</font></br>";
echo "<b><font color=#FA58AC>|<u>     N O D E   M O N I T O R     </u></b>|</font>   Monitoring $xios_count nodes :</br>";
echo '</div>';
?>
