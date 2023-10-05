<HTML>
<HEAD> <TITLE>EJERCICIO ARRAY MULTIDIMENSIONALES EJ7</TITLE> </HEAD>
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
$matriz = array(
	array("Nombre", "Base Datos", "Programacion Servicios y Procesos", "Programacion", "Desarrollo de Interfaces"),
	array("Iñigo",5,9,3,9),
	array("Alfredo",6,3,8,2),
	array("Oriol",8,7,3,7),
	array("Maria",10,2,9,7),
	array("Roberto",6,1,5,4),
	array("Samira",8,4,6,3),
	array("Miquel",8,10,7,9),
	array("Aranzazu",6,7,4,6),
	array("Jesus",3,9,4,6),
	array("Fabiola",10,6,2,5)
);
$notaBaseDatosMay = 0;
$notaPSPMay = 0;
$notaPSPMen = 10;
$notaPMay = 0;
$notaPMen = 10;
$notaDIMay = 0;
$notaDIMen = 10;
$notaBaseDatosMen = 10;
$alumnoNB = 10;
$alumnoNA = 0;
$tabla = "<table>";
$sumaBD = 0;
$sumaPSP = 0;
$sumaP = 0;
$sumaDI = 0;
$sumaNotas = 0;

foreach($matriz as $fila){
	$tabla .= "<tr>";
	foreach($fila as $elemento){
		$tabla .= "<td>".$elemento."</td>";
	}
	$tabla .= "</tr>";
}

for ($fila = 1; $fila < 11; $fila++) {
	$sumaBD += $matriz[$fila][1];
	$sumaPSP += $matriz[$fila][2];
	$sumaP += $matriz[$fila][3];
	$sumaDI += $matriz[$fila][4];
	for ($col = 1; $col < 5; $col++) {
		$sumaNotas += $matriz[$fila][$col];
		if($alumnoNA < $matriz[$fila][$col]){
			$alumnoNA = $matriz[$fila][$col];
			$asignatura = $matriz[0][$col];
		}
		if($alumnoNB > $matriz[$fila][$col]){
			$alumnoNB = $matriz[$fila][$col];
			$asignatura2 = $matriz[0][$col];
		}
	}
	$mediaAlumno = $sumaNotas / 4;
	echo "Alumno ".$matriz[$fila][0]." su mayor nota es en $asignatura un $alumnoNA <br/>";
	echo "Alumno ".$matriz[$fila][0]." su menor nota es en $asignatura2 un $alumnoNB <br/>";
	echo "Alumno ".$matriz[$fila][0]." media $mediaAlumno <br/>";
	$alumnoNA = 0;
	$alumnoNB = 10;
	$sumaNotas = 0;
	if($notaBaseDatosMay < $matriz[$fila][1]){
		$notaBaseDatosMay = $matriz[$fila][1];
		$nombreBDMay = $matriz[$fila][0];
	}
	if($notaBaseDatosMen > $matriz[$fila][1]){
		$notaBaseDatosMen = $matriz[$fila][1];
		$nombreBDMen = $matriz[$fila][0];
	}
	if($notaPSPMay < $matriz[$fila][2]){
		$notaPSPMay = $matriz[$fila][2];
		$nombrePSPMay = $matriz[$fila][0];
	}
	if($notaPSPMen > $matriz[$fila][2]){
		$notaPSPMen = $matriz[$fila][2];
		$nombrePSPMen = $matriz[$fila][0];
	}
	if($notaPMay < $matriz[$fila][3]){
		$notaPMay = $matriz[$fila][3];
		$nombrePMay = $matriz[$fila][0];
	}
	if($notaPMen > $matriz[$fila][3]){
		$notaPMen = $matriz[$fila][3];
		$nombrePMen = $matriz[$fila][0];
	}
	if($notaDIMay < $matriz[$fila][4]){
		$notaDIMay = $matriz[$fila][4];
		$nombreDIMay = $matriz[$fila][0];
	}
	if($notaDIMen > $matriz[$fila][4]){
		$notaDIMen = $matriz[$fila][4];
		$nombreDIMen = $matriz[$fila][0];
	}
}
$mediaBD = $sumaBD / 10;
$mediaPSP = $sumaPSP / 10;
$mediaP = $sumaP / 10;
$mediaDI = $sumaDI / 10;
$tabla .= "</table>";
echo $tabla;
echo "Alumno con mejor nota en Base de Datos : $nombreBDMay con nota de $notaBaseDatosMay .<br/>";
echo "Alumno con peor nota en Base de Datos : $nombreBDMen con nota de $notaBaseDatosMen .<br/>";
echo "Alumno con mejor nota en Programacion Servicios y Procesos : $nombrePSPMay con nota de $notaPSPMay .<br/>";
echo "Alumno con peor nota en Programacion Servicios y Procesos : $nombrePSPMen con nota de $notaPSPMen .<br/>";
echo "Alumno con mejor nota en Programacion : $nombrePMay con nota de $notaPMay .<br/>";
echo "Alumno con peor nota en Programacion : $nombrePMen con nota de $notaPMen .<br/>";
echo "Alumno con mejor nota en Desarrollo de Interfaces : $nombreDIMay con nota de $notaDIMay .<br/>";
echo "Alumno con peor nota en Desarrollo de Interfaces : $nombreDIMen con nota de $notaDIMen .<br/>";
echo "Media de Base de Datos : $mediaBD <br/>";
echo "Media de Programacion Servicios y Procesos : $mediaPSP <br/>";
echo "Media de Programacion : $mediaP <br/>";
echo "Media de Desarrollo de Interfaces : $mediaDI <br/>";


?>
</BODY>
</HTML>