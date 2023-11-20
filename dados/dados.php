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
<?php
//RECOJO LOS VALORES ENVIADOS POR EL FORMULARIO HTML
$jugador1 = test_input($_POST['Jugador1']);
$jugador2 = test_input($_POST['Jugador2']);
$jugador3 = test_input($_POST['Jugador3']);
$jugador4 = test_input($_POST['Jugador4']);
//RECOJO LOS VALORES QUE ESCRIBES EN EL FORMULARIO DE LOS JUGADORES
//Y LO ALMACENO EN UN ARRAY
$jugadores = array($jugador1, $jugador2, $jugador3, $jugador4);
$dados = test_input($_POST['dados']);
$tirada = tirada($jugadores, $dados);
$tabla = tabla($tirada);
//IMPRIMO LOS RESULTADOS
echo "<h1> RESULTADO JUEGO DADOS </h1>";
echo $tabla;
mostrar_ganadores($tirada);

//FUNCION QUE GENERA UN ARRAY CON CADA TIRADA DE CADA JUGADOR, TAMBIÉN
//GENERA LAS EXCEPCIONES SEGÚN QUE PASE
function tirada($jugadores,$dados){
	$dadosObtenidos = array();
	//COMPRUEBO QUE SE HAYA INTRODUCIDO NOMBRES A TODOS LOS JUGADORES
	if(!valor_vacio_jugador($jugadores)){
		//COMPRUEBO SI EL DATO QUE SE HA INTRODUCIDO DENTRO DE NUMERO
		//DE DADOS ES UN NUMERO
		if(is_numeric($dados)){
			//COMPRUEBO QUE EL NUMERO INTRODUCIDO SU RANGO SEA DE 
			//1 A 10
			if($dados > 0 && $dados < 11) {
				//RECORRO EL ARRAY DE JUGADORES
				foreach($jugadores as $jugadorNumero => $jugador){
					for($i = 1; $i <= $dados; $i++){
						//GENERO UN NUMERO ALEATORIO ENTRE 1 A 6
						//POR CADA TIRADA DE DADOS
						$dadosObtenidos[$jugadorNumero][0] = $jugador;
						$dadosObtenidos[$jugadorNumero][$i] = rand(1,6);
					}
				}
			}
			//GENERO UNA EXCEPCION SI EL NUMERO DE TIRADAS ES NEGATIVO
			else if($dados < 0){
				throw new Exception("Numero de tiradas negativas");
			}
			//GENERO UNA EXCEPCION SI EL NUMERO DE TIRADAS ES MAYOR QUE
			//10
			else if($dados > 10){
				throw new Exception("Demasiadas tiradas, solo puede 
				tirar maximo 10 tiradas y minimo 1");
			}
		}
		//GENERO UNA EXCEPCION SI EL NUMERO DE TIRADAS NO ES NUMERICO
		else if(!is_numeric($dados)){
			throw new Exception("No has puesto el numero de tiradas");
		}
	}
	//GENERO UNA EXCEPCION SI NO HAS INTRODUCIDO EL NOMBRE DE ALGUN
	//JUGADOR
	else if(valor_vacio_jugador($jugadores)){
		throw new Exception("Hay un jugador sin nombre");
	}
	return $dadosObtenidos;
}

//FUNCION QUE DETECTA DENTRO DEL ARRAY DE JUGADORES SI HAY ALGUN
//VALOR VACIO, ES DECIR, QUE HAY ALGUN JUGADOR SIN NOMBRE
function valor_vacio_jugador($array){
	return in_array("",$array,true);
}

//FUNCION QUE OBTIENE LAS PUNTUACIONES Y LOS GANADORES Y LOS ALMACENO
//DENTRO DEL FICHERO RESULTADOS.TXT
function mostrar_ganadores($array){
    $resultados = [];
	$f1=fopen("resultados.txt","a+");

    foreach($array as $jugador){
		//PILLO EL PRIMER VALOR DEL ARRAY PARA EL NOMBRE
        $nombre = array_shift($jugador);
        $suma = 0;
        $tiradas = [];
		
		//RECORRO AL JUGADOR Y ALMACENO LA SUMA Y SUS TIRADAS
        foreach($jugador as $tirada){
            if(is_numeric($tirada)){
                $suma += $tirada;
                $tiradas[] = $tirada;
            }
        }

        //SI TODAS LAS TIRADAS DEL JUGADOR SON IGUALES LA SUMA SE 
		//IGUALA A 100
        if(iguales($tiradas)){
            $suma = 100;
        }
		
        $resultados[$nombre] = $suma;
        echo "$nombre = $suma <br/>";
		//ESCRIBO DENTRO DEL FICHERO TXT
		fwrite($f1,$nombre."#");
		fwrite($f1,$suma."#");
		foreach($tiradas as $tirada){
			fwrite($f1,$tirada."#");
		}
		fwrite($f1,"\n");
    }

    //ENCONTRAMOS AL GANADOR O LOS GANADORES
    $maxSum = max($resultados);
    $ganadores = array_keys($resultados, $maxSum);

	//SI HAY MAS DE UN GANADOR MOSTRARA TODOS LOS GANADORES
    if(count($ganadores) > 1) {
		//RECORRO EL ARRAY CON LOS MISMOS MAYORES RESULTADOS
        foreach($ganadores as $ganador) {
            echo "GANADOR: $ganador <br/>";
        }
        echo "NUMERO DE GANADORES:".count($ganadores);
    }
	//SI SOLO HAY UN GANADOR SOLO MOSTRARA ESTE
	else {
        $ganador = $ganadores[0];
        echo "GANADOR: $ganador <br/>";
		echo "NUMERO DE GANADORES:".count($ganadores);
    }
	fclose($f1);
}

//FUNCION QUE RECORRE LAS TIRADAS DEL JUGADOR Y VE SI HA LANZADO 
//EL MISMO NUMERO, ES DECIR, SI EL JUGADOR LANZA 3 UNOS LA FUNCION
//DEVOLVERA TRUE, SI LANZA 2 UNOS Y 1 CUATRO DEVOLVERA FALSE
function iguales($array) {
	//RECOJO EL PRIMER VALOR DEL ARRAY
    $primerValor = current($array);
	//RECORRO EL ARRAY
    foreach ($array as $valor) {
		//COMPRUEBO SI EL PRIMER VALOR ES IGUAL AL RESTO DE VALORES
		//DEL ARRAY
        if ($primerValor !== $valor) {
            return false;
        }
    }
    return true;
}

//FUNCION QUE MOSTRARA LA TABLA
function tabla($array){
	$tabla = "<table>";
	//RECORRO EL ARRAY
	foreach($array as $jugador){
		$tabla .= "<tr>";
		foreach($jugador as $tirada){
			//SI ES UN NUMERO MOSTRARA LA IMAGEN DEL DADO
			if(is_numeric($tirada)){
				$tabla .= "<td><img src='images/".$tirada.".PNG' style='width:100px;heigth:100px;'></td>";
			}
			//SI NO ES UN NUMERO MOSTRARA EL NOMBRE DEL JUGADOR
			else{
				$tabla .= "<td style='width:30%;'>".$tirada."</td>";
			}
		}
		$tabla .= "</tr>";
	}
	$tabla .= "</table>";
	return $tabla;
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>