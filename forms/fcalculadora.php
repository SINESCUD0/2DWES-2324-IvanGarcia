<HTML>
<HEAD> <TITLE>CALCULADORA</TITLE>
</HEAD>
<BODY>
<h1>CALCULADORA</h1>
<form name='mi_formulario' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
Operando 1:
<input type='number' name='operando1' value=''><br>
Operando 2:
<input type='number' name='operando2' value=''><br>
Selecciona operacion:<br>
<input type='radio' name='operacion' value='Suma'>Suma</br>
<input type='radio' checked name='operacion' value='Resta'>Resta</br>
<input type='radio' name='operacion' value='Producto'>Producto</br>
<input type='radio' name='operacion' value='Division'>Division</br>
<input type="submit" value="enviar">
<input type="reset" value="borrar">
</FORM>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$operando1 = test_input($_POST['operando1']);
	$operando2 = test_input($_POST['operando2']);
	$operacion = test_input($_POST['operacion']);
	echo "<h1> CALCULADORA </h1>";
	$calculo = calculadora($operando1,$operando2,$operacion);
	echo $calculo;
}

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
</BODY>
</HTML>
