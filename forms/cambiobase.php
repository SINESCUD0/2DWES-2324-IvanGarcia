<?php
echo "
<style>
table {
  border-collapse: collapse;
}
td, tr{
  border: 1px solid black;
  text-align: left;
  padding: 8px;
}
</style>
";
$decimal = test_input($_POST['decimal']);
echo "<h1> CONVERSOR NUMERICO </h1>";
echo "Numero decimal: $decimal <br/><br/>";
$base = $_POST['base'];
$binario = "";
$octal = "";
$hexadecimal = "";
$num = $decimal;
$resultado = "";
$resultado1 = "";
$resultado2 = "";
switch($base){
	case 'Binario':
		while($num != 0){
			$resultado .= intval($num) % 2;
			$num = intval($num)/2;
		}
		break;
	case 'Octal':
		while($num != 0){
			$resultado .= intval($num) % 8;
			$num = intval($num)/8;
		}
		break;
	case 'Hexadecimal':
		while($num != 0){
			$modulo = intval($num) % 16;
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
				$resultado .= intval($num) % 16;
			}
			$num = intval($num)/16;
		}
		break;
	case 'Todos':
		$num1 = $decimal;
		$num2 = $decimal;
		while($num != 0){
			$resultado .= intval($num) % 2;
			$num = intval($num)/2;
		}
		while($num1 != 0){
			$resultado1 .= intval($num1) % 8;
			$num1 = intval($num1)/8;
		}
		while($num2 != 0){
			$modulo = intval($num2) % 16;
			if($modulo >= 10){
				switch($modulo){
					case 10:
					$resultado2 .= "A";
					break;
					case 11:
					$resultado2 .= "B";
					break;
					case 12:
					$resultado2 .= "C";
					break;
					case 13:
					$resultado2 .= "D";
					break;
					case 14:
					$resultado2 .= "E";
					break;
					case 15:
					$resultado2 .= "F";
					break;
				}
			}else{
				$resultado2 .= intval($num2) % 16;
			}
			$num2 = intval($num2)/16;
		}
		$resultado1 = strrev($resultado1);
		$resultado2 = strrev($resultado2);
		if($resultado1[0] == 0){
			$resultado1 = substr($resultado1,1); 
		}
		if($resultado2[0] == 0){
			$resultado2 = substr($resultado2,1); 
		}
		break;
}
$resultado = strrev($resultado);

if($resultado[0] == 0){
	$resultado = substr($resultado,1); 
}
switch($base){
	case 'Binario':
		echo "Numero binario: $resultado";
		break;
	case 'Octal':
		echo "Numero octal: $resultado";
		break;
	case 'Hexadecimal':
		echo "Numero hexadecimal: $resultado";
		break;
	case 'Todos':
		echo "<table><tr><td>Binario</td><td>$resultado</td></tr>
					 <tr><td>Octal</td><td>$resultado1</td></tr>
					 <tr><td>Hexadecimal</td><td>$resultado2</td></tr>
			  </table>";
		break;
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>