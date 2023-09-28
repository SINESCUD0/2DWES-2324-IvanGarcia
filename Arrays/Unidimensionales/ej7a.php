<HTML>
<HEAD> <TITLE>EJERCICIO ARRAY ASOCIATIVO EJ7</TITLE> </HEAD>

<BODY>
<?php
$alumnos = array("Ivan" => 20, "Ayman"=> 23, "Carlos" => 23, "Manu" => 20, "Yeisi" => 21);
foreach($alumnos as $nombre => $edad){
	echo "Nombre: ".$nombre." | Edad: ".$edad."<br/>";
}
next($alumnos);
$segundaPosicion = current($alumnos);
var_dump($segundaPosicion);
$siguientePosicion = next($alumnos);
var_dump($siguientePosicion);
$puntero = end($alumnos);
var_dump($puntero);
arsort($alumnos);
$ordenados = array_reverse($alumnos);
var_dump($ordenados);
$primeraPosicion = current($ordenados);
var_dump($primeraPosicion);
$ultimaPosicion = end($ordenados);
var_dump($ultimaPosicion);
?>
</BODY>
</HTML>