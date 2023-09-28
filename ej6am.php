<HTML>
<HEAD> <TITLE>EJERCICIO ARRAY MULTIDIMENSIONALES EJ6</TITLE> </HEAD>
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
$matriz = array();
$matriz2 = array();
$matriz3 = array();
$tabla = "<table>";
$tabla2 = "<table>";
$tabla3 = "<table>";
for ($fila = 0; $fila < 3; $fila++) {
	$tabla .= "<tr>";
	$tabla2 .= "<tr>";
	$tabla3 .= "<tr>";
	$numMax = 0;
	$sumaFila = 0;
	for ($col = 0; $col < 3; $col++) {
		$matriz[$fila][$col] = rand();
		$sumaFila += $matriz[$fila][$col];
		if($numMax < $matriz[$fila][$col]){
			$numMax = $matriz[$fila][$col];
		}
		$tabla .= "<td>".$matriz[$fila][$col]."</td>";
	}
	$matriz3[$fila] = $sumaFila/3;
	$matriz2[$fila] = $numMax;
	$tabla2 .= "<td>".$matriz2[$fila]."</td></tr>";
	$tabla3 .= "<td>".$matriz3[$fila]."</td></tr>";
	$tabla .= "</tr>";
}
$tabla .= "</table>";
$tabla2 .= "</table>";
$tabla3 .= "</table>";
var_dump($matriz);
var_dump($matriz2);
var_dump($matriz3);
echo $tabla."<br/>";
echo $tabla2."<br/>";
echo $tabla3;
?>
</BODY>
</HTML>