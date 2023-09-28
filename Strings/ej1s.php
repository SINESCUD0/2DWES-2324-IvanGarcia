<HTML>
<HEAD><TITLE> EJ1-Conversion IP Decimal a Binario </TITLE></HEAD>
<BODY>
<?php
$ip="192.18.16.204";
$position = explode(".", $ip);
printf("IP $ip a binario = %b.%b.%b.%b <br/>",$position[0],$position[1],$position[2],$position[3]);
//printf("%b .",$position[0],"%b .",$position[1],"%b .",$position[2],"%b",$position[3]);
$valorIP = sprintf("IP $ip a binario = %b.%b.%b.%b <br/>",$position[0],$position[1],$position[2],$position[3]);
echo $valorIP;
?>
</BODY>
</HTML>
