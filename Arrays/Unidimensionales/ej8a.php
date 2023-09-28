<HTML>
<HEAD> <TITLE>EJERCICIO ARRAY ASOCIATIVO EJ8</TITLE> </HEAD>

<BODY>
<?php
$calificaciones = array ("Juan"=>9, "Pedro"=>7, "Ana"=>10, "Marta"=>3, "Adrian"=>4);
var_dump($calificaciones);
$notaMenor = 10;
$notaMayor = -1;
$sumaNotas = 0;
foreach($calificaciones as $nombre => $nota){
	$sumaNotas += $nota;
	if($nota < $notaMenor){
		$notaMenor = $nota;
	}
	if($nota > $notaMayor){
		$notaMayor = $nota;
	}
}
$mediaNotas = $sumaNotas / count($calificaciones);
echo "Nota menor = ".$notaMenor." Nota mayor = ".$notaMayor." Media de todos los alumnos = ".$mediaNotas."<br/>";
?>
</BODY>
</HTML>