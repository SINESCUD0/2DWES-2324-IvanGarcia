<HTML>
<HEAD><TITLE> EJ3-Direccion Red – Broadcast y Rango</TITLE></HEAD>
<BODY>
<?php
//$ip="10.33.15.100/8";
//$ip = "192.168.16.100/16";
$ip = "192.168.16.100/20";
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
//echo $bitsHost."<br/>";
foreach($octeto as $octetos){
	$binario.=str_pad(decbin($octetos), 8, "0", STR_PAD_LEFT);
}
$mascaraBinario = substr($binario,0,-$bitsHost);
//echo $binario."<br/>";
//var_dump($mascaraBinario);

$BinDireccionRed = str_pad($mascaraBinario,$bits,"0");
$BinDireccionRed2 = str_split($BinDireccionRed, 8);
$BinDireccionBroadcast = str_pad($mascaraBinario,$bits,"1");
$BinDireccionBroadcast2 = str_split($BinDireccionBroadcast, 8);
$BinDireccionHost1 = substr($BinDireccionRed, 0, -1)."1";
$BinDireccionHostUlt = substr($BinDireccionBroadcast, 0, -1)."0";
//var_dump($BinDireccionRed);
//print_r($BinDireccionRed2);
//var_dump($BinDireccionBroadcast);
//print_r($BinDireccionBroadcast2);

foreach($BinDireccionRed2 as $bin){
	$direccionRed .=  bindec($bin). ".";
}
$direccionRed = substr($direccionRed, 0 ,-1);
//var_dump($direccionRed);
foreach($BinDireccionBroadcast2 as $bin){
	$direccionBroadcast .=  bindec($bin). ".";
}
$direccionBroadcast = substr($direccionBroadcast, 0 ,-1);
//var_dump($direccionBroadcast);
$BinDireccionHost1 = substr($BinDireccionRed, 0, -1)."1";
//var_dump($BinDireccionHost1);
$direccionHost1_sep = str_split($BinDireccionHost1, 8);
foreach($direccionHost1_sep as $octetos){
	$direccionHost1 .= bindec($octetos). ".";
}
$direccionHost1 = substr($direccionHost1, 0, -1);
$BinDireccionHostUlt = substr($BinDireccionBroadcast, 0, -1)."0";
$direccionHostUlt_sep = str_split($BinDireccionHostUlt, 8);
foreach($direccionHostUlt_sep as $octetos){
	$direccionHostUlt .= bindec($octetos). ".";
}
$direccionHostUlt = substr($direccionHostUlt, 0, -1);

/*echo "Binarios <br/>";
echo "Direccion Red ".$BinDireccionRed."<br/>";
echo "Mascara binario ".$mascaraBinario."<br/>";
echo "Binario de la mascara de red ".$binario2."<br/>";
echo "Direccion ultimo host ".$BinDireccionHost1."<br/>";
echo "Direccion ultimo host ".$BinDireccionHostUlt."<br/>";
print_r($BinDireccionRed2);
echo "<br/>";*/
printf("IP $ip <br/> Mascara $mascara <br/> Direccion Red: $direccionRed <br/> Direccion Broadcast: $direccionBroadcast<br/> Rango: $direccionHost1 a $direccionHostUlt<br/>");
?>
</BODY>
</HTML>
