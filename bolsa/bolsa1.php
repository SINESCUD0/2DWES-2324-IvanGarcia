<HTML>
<HEAD> <TITLE>BOLSA 1</TITLE>
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
	$f1=file("ibex35.txt");
	$tabla = "<table>";
	foreach($f1 as $texto) {
		$filas = preg_split('/\s{2,}/', trim($texto));
		$tabla .= "<tr>";
		foreach($filas as $columna){
			$tabla .= "<td>$columna</td>";
		}
		$tabla .= "</tr>";
	}
	echo $tabla."</table>";
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