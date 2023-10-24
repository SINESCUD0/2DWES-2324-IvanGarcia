<HTML>
<HEAD> <TITLE>BINGO</TITLE> </HEAD>
<STYLE>
table {
  border-collapse: collapse;
}
td, tr{
  border: 1px solid black;
  text-align: left;
  padding: 8px;
}
</STYLE>
<BODY>
<?php
$numeros_generados = array();
$jugador1 = array();
$jugador2 = array();
$jugador3 = array();
$bombo = array();

$jugador1 = dar_cartones($jugador1);
$jugador2 = dar_cartones($jugador2);
$jugador3 = dar_cartones($jugador3);

var_dump($jugador1);
var_dump($jugador2);
var_dump($jugador3);

$bombo = sacar_ganador($numeros_generados, $jugador1, $jugador2, $jugador3);
echo "<br/>Comprobar cartones";
var_dump($bombo);

//Funcion que genere los cartones aleatoriamente
function generar_carton($carton){
	$min = 1;
	$max = 60;
	$cantidad_numeros = 15;
	while(count($carton) != 15){
		do {
			$numero_aleatorio = rand($min, $max);
		} while (in_array($numero_aleatorio, $carton));
			$carton[] = $numero_aleatorio;
	}
	return $carton;
}

//Funcion que genera tres cartones aleatoriamente
function dar_cartones($jugador){
	$carton1 = array();
	$carton2 = array();
	$carton3 = array();
	$carton1 = generar_carton($carton1);
	$carton2 = generar_carton($carton2);
	$carton3 = generar_carton($carton3);
	$jugador = array($carton1, $carton2, $carton3);
	return $jugador;
}

//Funcion que recorre los cartones de los jugadores
function eliminar_valor($jugador, $numero_aleatorio){
	foreach ($jugador as $fila => $subfila) {
		foreach($subfila as $columna => $elemento){
			if($elemento == $numero_aleatorio){
				//Si el numero aleatorio generado esta dentro del array del jugador1 eliminamos dicho numero del array
				unset($jugador[$fila][$columna]);
			}
		}
	}
	$jugador = array_values($jugador);
	//$jugador = array_diff($jugador, array($numero_aleatorio));
	return $jugador;
}

//Funcion que recorre los tres cartones de los jugadores y indica si hay algun carton completado
function carton_vacio($jugador){
	$i = 0;
	foreach ($jugador as $fila) {
		if(empty($fila)){
			$i++;
		}
	}
	return $i;
}

//Funcion que genera los numeros aleatoriamente
function sacar_ganador($numeros_generados, $jugador1, $jugador2, $jugador3){
	$min = 1;
	$max = 60;
	$ganador = "";
	while(count($numeros_generados) != 60){
		do {
			$numero_aleatorio = rand($min, $max);
		} while (in_array($numero_aleatorio, $numeros_generados));
			$numeros_generados[] = $numero_aleatorio;
			echo "<img src='images/".$numero_aleatorio.".PNG'>";
			$jugador1 = eliminar_valor($jugador1,$numero_aleatorio);
			$jugador2 = eliminar_valor($jugador2,$numero_aleatorio);
			$jugador3 = eliminar_valor($jugador3,$numero_aleatorio);

			if(carton_vacio($jugador1) != 0 && carton_vacio($jugador2) != 0 && carton_vacio($jugador3) != 0){
				$ganador .= "Tenemos ganador jugador 1, 2 y 3, donde jugador 1 canta ".carton_vacio($jugador1)." bingos, el jugador 2 canta ".carton_vacio($jugador2)." bingos y el jugador 3 canta ".carton_vacio($jugador3)." bingos";
				return [$ganador, $jugador1, $jugador2, $jugador3, $numeros_generados];
			}
			elseif(carton_vacio($jugador1) != 0 && carton_vacio($jugador2) != 0 && carton_vacio($jugador3) == 0){
				$ganador .= "Tenemos ganador jugador 1 y 2, donde jugador 1 canta ".carton_vacio($jugador1)." bingos, el jugador 2 canta ".carton_vacio($jugador2)." bingos";
				return [$ganador, $jugador1, $jugador2, $jugador3, $numeros_generados];
			}
			elseif(carton_vacio($jugador1) != 0 && carton_vacio($jugador2) == 0 && carton_vacio($jugador3) != 0){
				$ganador .= "Tenemos ganador jugador 1 y 3, donde jugador 1 canta ".carton_vacio($jugador1)." bingos, el jugador 3 canta ".carton_vacio($jugador3)." bingos";
				return [$ganador, $jugador1, $jugador2, $jugador3, $numeros_generados];
			}
			elseif(carton_vacio($jugador1) == 0 && carton_vacio($jugador2) != 0 && carton_vacio($jugador3) != 0){
				$ganador .= "Tenemos ganador jugador 2 y 3, donde jugador 2 canta ".carton_vacio($jugador2)." bingos, el jugador 3 canta ".carton_vacio($jugador3)." bingos";
				return [$ganador, $jugador1, $jugador2, $jugador3, $numeros_generados];
			}
			elseif(carton_vacio($jugador1) != 0 && carton_vacio($jugador2) == 0 && carton_vacio($jugador3) == 0){ //si un carton de el jugador esta vacio es el ganador
				$ganador .= "Tenemos ganador jugador 1 cantando ".carton_vacio($jugador1)." bingos";
				return [$ganador, $jugador1, $jugador2, $jugador3, $numeros_generados];
			}
			elseif(carton_vacio($jugador2) != 0 && carton_vacio($jugador1) == 0 && carton_vacio($jugador3) == 0){ //si un carton de el jugador esta vacio es el ganador
				$ganador .= "Tenemos ganador jugador 2 cantando ".carton_vacio($jugador2)." bingos";
				return [$ganador, $jugador1, $jugador2, $jugador3, $numeros_generados];
			}
			elseif(carton_vacio($jugador3) != 0 && carton_vacio($jugador2) == 0 && carton_vacio($jugador1) == 0){ //si un carton de el jugador esta vacio es el ganador
				$ganador .= "Tenemos ganador jugador 3 cantando ".carton_vacio($jugador3)." bingos";
				return [$ganador, $jugador1, $jugador2, $jugador3, $numeros_generados];
			}
			
	}
}

?>
</BODY>
</HTML>