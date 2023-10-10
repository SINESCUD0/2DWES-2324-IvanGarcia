<?php
$decimal = test_input($_POST['decimal']);
echo "<h1> CONVERSOR BINARIO </h1>";
echo "Numero decimal: $decimal <br/>";

$binario = pasarBinario($decimal);
echo "Numero binario: $binario";

function pasarBinario($num){
	$resultado = "";
	while($num != 0){
		$resultado .= intval($num) % 2;
		$num = intval($num)/2;
	}
	$resultado = strrev($resultado);
	if($resultado[0] == 0){
		$resultado = substr($resultado,1); 
	}
	return $resultado;
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>