<?php
$operando1 = test_input($_POST['operando1']);
$operando2 = test_input($_POST['operando2']);
$operacion = test_input($_POST['operacion']);
echo "<h1> CALCULADORA </h1>";
$calculo = calculadora($operando1,$operando2,$operacion);
echo $calculo;

function calculadora($num1,$num2,$opcion){
	$resultado = "";
	switch($opcion){
		case 'Suma':
			$suma = $num1 + $num2;
			$resultado = "Resultado operacion: $num1 + $num2 = $suma";
			break;
		case 'Resta':
			$resta = $num1 - $num2;
			$resultado = "Resultado operacion: $num1 - $num2 = $resta";
			break;
		case 'Producto':
			$producto = $num1 * $num2;
			$resultado = "Resultado operacion: $num1 * $num2 = $producto";
			break;
		case 'Division':
			$division = $num1 / $num2;
			$resultado = "Resultado operacion: $num1 / $num2 = $division";
			break;
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