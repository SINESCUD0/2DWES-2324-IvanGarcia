<HTML>
<HEAD> <TITLE>EJERCICIO ARRAY UNIDIMENSIONALES EJ1</TITLE> </HEAD>

<BODY>
<?php
$numero = 0;
$contador = 0;
while($contador != 20){
	if(numeroPrimo($numero)){
		$numerosPrimos[$contador] = $numero;
		$contador++;
	}
	$numero++;
}
function numeroPrimo($numero1){
	$VboPrimo = true;
	if($numero1 <= 1){
		$VboPrimo = false;
	}
	for($i = 2; $i < $numero1; $i++){
		if($numero1 % $i == 0){
			$VboPrimo = false;
		}
	}
	return $VboPrimo;
}
var_dump($numerosPrimos);
$suma = 0;
foreach($numerosPrimos as $indice => $valor){
	$suma = $suma + $valor;
	echo "Indice = ".$indice." Valor = ".$valor." Suma = ".$suma."<br/>";
}
?>
</BODY>
</HTML>