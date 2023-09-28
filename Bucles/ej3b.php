<HTML>
<HEAD><TITLE> EJ3B – Conversor Decimal a base 16</TITLE></HEAD>
<BODY>
<?php
$num="500";
$num2 = $num;
$base="16";
$resultado = "";

while($num != 0){
	$modulo = intval($num) % intval($base);
	if($modulo >= 10){
		switch($modulo){
			case 10:
			$resultado .= "A";
			break;
			case 11:
			$resultado .= "B";
			break;
			case 12:
			$resultado .= "C";
			break;
			case 13:
			$resultado .= "D";
			break;
			case 14:
			$resultado .= "E";
			break;
			case 15:
			$resultado .= "F";
			break;
		}
	}else{
		$resultado .= intval($num) % intval($base);
	}
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