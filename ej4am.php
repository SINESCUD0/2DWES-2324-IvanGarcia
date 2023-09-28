<HTML>
<HEAD> <TITLE>EJERCICIO ARRAY MULTIDIMENSIONALES EJ4</TITLE> </HEAD>
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
	array(2, 4, 6, 9, 7),
	array(8, 10, 12 , 1, 12),
	array(14, 16, 88, 3, 15)
);
$numMay = 0;
$fi = 0;
$co = 0;
$columna = 0;
$fil = 0;
$tabla = "<table>";
foreach($matriz as $fila){
	$tabla .= "<tr>";
	$fil++;
	foreach($fila as $elemento){
		$columna++;
		if($numMay < $elemento){
			$numMay = $elemento;
			$co = $columna;
			$fi = $fil;
		}
		$tabla .= "<td>".$elemento."</td>";
	}
	$columna = 0;
	$tabla .= "</tr>";
}
$tabla .= "</table>";
echo $tabla;
echo "Numero mayor = $numMay que esta en la fila $fi y la columna $co";
?>
</BODY>
</HTML>