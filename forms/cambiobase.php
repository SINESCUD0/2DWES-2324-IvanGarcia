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
$resultado = "";
$resultado1 = "";
$resultado2 = "";
switch($base){
	case 'Binario':
		$resultado = conversor($decimal, 2);
		break;
	case 'Octal':
		$resultado = conversor($decimal, 8);
		break;
	case 'Hexadecimal':
		$resultado = conversor($decimal, 16);
		break;
	case 'Todos':
		$resultado = conversor($decimal, 2);
		$resultado1 = conversor($decimal, 8);
		$resultado2 = conversor($decimal, 16);
		break;
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
function conversor($numero, $base){
	$result = "";
	
	while($numero != 0){
		if($base == 2 || $base == 8){
			$result .= intval($numero) % intval($base);
			$numero = intval($numero)/intval($base);
		}
		else if($base == 16){
			$modulo = intval($numero) % intval($base);
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
				$result .= intval($numero) % intval($base);
			}
			$numero = intval($numero)/intval($base);
		}
	}
	$result = strrev($result);
	if($result[0] == 0){
		$result = substr($result,1); 
	}
	return $result;
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>