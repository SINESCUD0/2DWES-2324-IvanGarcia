<HTML>
<HEAD> <TITLE>FICHERO 3</TITLE>
</HEAD>
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
leer_fichero();

function leer_fichero(){
	$tabla = "<table><tr><td>Nombre</td><td>Apellido 1</td><td>Apellido 2</td><td>Fecha nacimiento</td><td>Localidad</td></tr>";
	$f1=file("alumnos1.txt");
	foreach($f1 as $linea=>$texto) {
		$nombre = substr($texto, 0, 40);
		$apellido1 = substr($texto, 40, 40);
		$apellido2 = substr($texto, 80, 41);
		$fecha = substr($texto, 121, 10);
		$localidad = substr($texto, 131, 26);
		$numfilas = $linea + 1;
		$tabla .= "<tr><td>$nombre</td><td>$apellido1</td><td>$apellido2</td><td>$fecha</td><td>$localidad</td></tr>";
	};
	$tabla .= "</table>";
	echo $tabla."<br/>"."Numero de filas: $numfilas";
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