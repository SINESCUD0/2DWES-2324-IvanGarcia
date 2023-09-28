<HTML>
<HEAD><TITLE> EJ2B – Conversor Decimal a base n </TITLE></HEAD>
<BODY>
<?php
$num="48";
$base = "6";
$num2 = $num;
$resultado = "";
var_dump(intval($num));
while($num != 0){
	$resultado .= intval($num) % intval($base);
	$num = intval($num)/intval($base);
}
$resultado = strrev($resultado);

if($resultado[0] == 0){
	$resultado = substr($resultado,1); 
}
echo "Numero $num2 en $base = ".$resultado;
?>
</BODY>
</HTML>