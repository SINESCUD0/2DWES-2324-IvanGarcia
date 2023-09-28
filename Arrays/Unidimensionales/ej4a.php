<HTML>
<HEAD> <TITLE>EJERCICIO ARRAY UNIDIMENSIONALES EJ4</TITLE> </HEAD>

<BODY>
<?php
$numero = 0;
$contador = 0;
for($i = 0; $i <=20; $i++){
	$numerosBinarios[$i] = decbin($i);
}
var_dump(array_reverse($numerosBinarios));
foreach(array_reverse($numerosBinarios) as $indice => $valor){
	echo "Indice = ".$indice." Binario = ".$valor."<br/>";
}
?>
</BODY>
</HTML>