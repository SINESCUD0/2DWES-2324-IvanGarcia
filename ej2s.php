<HTML>
<HEAD><TITLE> EJ2-Conversion IP Decimal a Binario sin usar printf o sprintf </TITLE></HEAD>
<BODY>
<?php
$ip="192.18.16.204";
$position = explode(".", $ip);
$binario = "";
foreach($position as $octetos){
	$binario.=str_pad(decbin($octetos), 8, "0", STR_PAD_LEFT) . ".";
}
echo "IP $ip a binario = ".$binario."<br/>";
?>
</BODY>
</HTML>
