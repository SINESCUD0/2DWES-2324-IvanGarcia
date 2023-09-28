<HTML>
<HEAD> <TITLE>EJERCICIO ARRAY UNIDIMENSIONALES EJ2</TITLE> </HEAD>

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
$contPar = 0;
$contImpar = 0;
$sumaTotalPar = 0;
$sumaTotalImpar = 0;
foreach($numerosPrimos as $indice => $valor){
	$suma = $suma + $valor;
	if($indice % 2 == 0){
		$sumaTotalPar += $valor;
		$contPar++;
	}else{
		$sumaTotalImpar += $valor;
		$contImpar++;
	}
	echo "Indice = ".$indice." Valor = ".$valor." Suma = ".$suma."<br/>";
}
$mediaPar = $sumaTotalPar / $contPar;
$mediaImpar = $sumaTotalImpar / $contImpar;
echo "Media Pares = ".$mediaPar." Media Impares = ".$mediaImpar;
?>
</BODY>
</HTML>