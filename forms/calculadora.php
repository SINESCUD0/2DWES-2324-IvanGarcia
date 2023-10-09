<?php
$operando1 = test_input($_POST['operando1']);
$operando2 = test_input($_POST['operando2']);
echo "<h1> CALCULADORA </h1>";
switch($_POST['operacion']){
	case 'Suma':
		$suma = $operando1 + $operando2;
		echo "Resultado operacion: $operando1 + $operando2 = $suma";
		break;
	case 'Resta':
		$resta = $operando1 - $operando2;
		echo "Resultado operacion: $operando1 - $operando2 = $resta";
		break;
	case 'Producto':
		$producto = $operando1 * $operando2;
		echo "Resultado operacion: $operando1 * $operando2 = $producto";
		break;
	case 'Division':
		$division = $operando1 / $operando2;
		echo "Resultado operacion: $operando1 / $operando2 = $division";
		break;
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>