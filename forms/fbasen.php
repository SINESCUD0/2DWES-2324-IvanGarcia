<HTML>
<HEAD> <TITLE>CAMBIO DE BASE</TITLE>
</HEAD>
<BODY>
<h1>CAMBIO DE BASE</h1>
<form name='mi_formulario' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
Numero:
<input type='text' name='numero' value=''></br></br>
Nueva Base:
<input type='number' name='base' value=''></br></br>
<input type="submit" value="Cambio Base">
<input type="reset" value="borrar">
</FORM>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$numeroBase = test_input($_POST['numero']);
	$cambioBase = test_input($_POST['base']);
	$posicion = explode("/",$numeroBase);
	$numero = $posicion[0];
	$baseNumero = $posicion[1];
	$resultado = "";
	$numero = quitar_cero($numero);
	switch($baseNumero){
		case '2':
			$num = binarioADecimal($numero);
			$resultado = cambio_base($num, $cambioBase);
			break;
		case '4':
			$num = pasar_decimal($numero, 4);
			$resultado = cambio_base($num, $cambioBase);
			break;
		case '6':
			$num = pasar_decimal($numero, 6);
			$resultado = cambio_base($num, $cambioBase);
			break;
		case '8':
			$num = pasar_decimal($numero, 8);
			$resultado = cambio_base($num, $cambioBase);
			break;
		case '10':
			$num = pasar_decimal($numero, 10);
			$resultado = cambio_base($num, $cambioBase);
			break;
		case '16':
			$num = pasar_decimal($numero, 16);
			$resultado = cambio_base($num, $cambioBase);
			break;
	}

	echo "Numero $numero en base $baseNumero = $resultado en base $cambioBase <br/><br/>";
}
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function quitar_cero($data){
	while($data[0] == 0){
		if($data[0] == 0){
			$data = substr($data,1);
		}
	}
	return $data;
}

function cambio_base($number, $bas){
	$result = "";
	if($bas != 16){
		while($number != 0){
			$result .= intval($number) % intval($bas);
			$number = intval($number)/intval($bas);
		}
	}else if($bas == 16){
		$modulo = intval($number) % 16;
		if($modulo >= 10){
			switch($modulo){
				case 10:
				$result .= "A";
				break;
				case 11:
				$result .= "B";
				break;
				case 12:
				$result .= "C";
				break;
				case 13:
				$result .= "D";
				break;
				case 14:
				$result .= "E";
				break;
				case 15:
				$result .= "F";
				break;
			}
		}else{
			$result .= intval($number) % 16;
		}
		$number = intval($number)/16;
	}
	$result = strrev($result);
	$result = quitar_cero($result);
	return $result;
}

function binarioADecimal($binario) {
	$decimal = 0;
	$longitud = strlen($binario);
	for ($i = 0; $i < $longitud; $i++) {
		$bit = $binario[$longitud - $i - 1];
		if ($bit == '1') {
			$decimal += pow(2, $i);
		}
	}
	return $decimal;
}

function pasar_decimal($number, $bas) {
	$decimal = 0;
	$longitud = strlen($number);

	for ($i = 0; $i < $longitud; $i++) {
		$digito = intval($number[$longitud - $i - 1]);
		$decimal += $digito * pow($bas, $i);
	}

	return $decimal;
}
?>
</BODY>
</HTML>
