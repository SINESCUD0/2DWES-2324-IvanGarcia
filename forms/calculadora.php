<?php
$operando1 = $_POST['operando1'];
$operando2 = $_POST['operando2'];
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
?>