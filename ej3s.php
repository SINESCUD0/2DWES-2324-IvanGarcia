<HTML>
<HEAD><TITLE> EJ3-Direccion Red – Broadcast y Rango</TITLE></HEAD>
<BODY>
<?php
$ip="10.33.15.100/8";
$position = explode("/", $ip);
$octeto = explode(".", $position[0]);
$binario="";
$binario2 = "";
$binario3 = "";
$direccionRed = "";
$direccionHost1 = "";
$direccionHostUlt = "";
$direccionBroadcast = "";
$mascara = $position[1];
$BinDireccionRed = "";
$BinDireccionRed2 = "";
$BinDireccionHost1 = "";
$BinDireccionHostUlt = "";
$BinDireccionBroadcast = "";
$BinDireccionBroadcast2 = "";
$bits = 32;
$bitsHost = $bits - intval($mascara);
echo $bitsHost."<br/>";
echo $octeto[0].".".$octeto[1].".".$octeto[2].".".$octeto[3]."<br/>";
foreach($octeto as $octetos){
	$binario.=str_pad(decbin($octetos), 8, "0", STR_PAD_LEFT) . ".";
	$binarioSinPuntos = str_replace(".","",$binario);
	$mascaraBinario = substr($binarioSinPuntos,$mascara);
}
echo $binario."<br/>";
$binario = substr($binario, 0, -1);
$octetoBin = explode(".", $binario);

//SACO EL BINARIO DE LA DIRECCION DE LA RED Y LA DIRECCION DEL BROADCAST
$binarioSep = explode($mascaraBinario, $binarioSinPuntos);
foreach($binarioSep as $bin){
	$BinDireccionRed.= str_pad($bin,$bitsHost,"0",STR_PAD_RIGHT);
	if(strlen($BinDireccionRed) == 32){
		break;
	}
	$BinDireccionRed2 = str_split($BinDireccionRed, 8);
	$BinDireccionBroadcast .= str_pad($bin,$bitsHost,"1",STR_PAD_RIGHT);
	$BinDireccionBroadcast2 = str_split($BinDireccionBroadcast, 8);
}
//SACO LA IP DE LA DIRRECCION DE LA RED
foreach($BinDireccionRed2 as $bin){
	$direccionRed .=  bindec($bin). ".";
}
$direccionRed = substr($direccionRed, 0 ,-1);
//SACO LA IP DE LA PRIMERA DIRECCION DEL HOST
$bn = explode(".", $direccionRed);
foreach($bn as $octetos){
	$binario2 .=str_pad(decbin($octetos), 8, "0", STR_PAD_LEFT) . ".";
}
$binario2 = substr($binario2, 0, -1);
$BinDireccionHost1 = substr($binario2, 0, -1)."1";
$bn2 = explode(".", $BinDireccionHost1);
foreach($bn2 as $octetos){
	$direccionHost1 .= bindec($octetos). ".";
}
$direccionHost1 = substr($direccionHost1, 0, -1);
//SACO LA IP DE LA DIRECCION DEL BROADCAST
foreach($BinDireccionBroadcast2 as $bin){
	$direccionBroadcast .= bindec($bin) . ".";
}
$direccionBroadcast = substr($direccionBroadcast, 0, -1);
$bn3 = explode(".", $direccionBroadcast);
foreach($bn3 as $octetos){
	$binario3 .=str_pad(decbin($octetos), 8, "0", STR_PAD_LEFT) . ".";
}
$binario3 = substr($binario3, 0, -1);
$BinDireccionHostUlt = substr($binario3, 0, -1)."0";
$bn4 = explode(".", $BinDireccionHostUlt);
foreach($bn4 as $octetos){
	$direccionHostUlt .= bindec($octetos). ".";
}
$direccionHostUlt = substr($direccionHostUlt, 0, -1);

echo "Binarios <br/>";
echo "Direccion Red ".$BinDireccionRed."<br/>";
echo "Mascara binario ".$mascaraBinario."<br/>";
echo "Binario de la mascara de red ".$binario2."<br/>";
echo "Direccion ultimo host ".$BinDireccionHost1."<br/>";
echo "Direccion ultimo host ".$BinDireccionHostUlt."<br/>";
echo $binarioSinPuntos."<br/>";
print_r($BinDireccionRed2);
echo "<br/>";
printf("IP $ip <br/> Mascara $mascara <br/> Direccion Red: $direccionRed <br/> Direccion Broadcast: $direccionBroadcast<br/> Rango: $direccionHost1 a $direccionHostUlt<br/>");
?>
</BODY>
</HTML>