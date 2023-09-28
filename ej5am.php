<HTML>
<HEAD> <TITLE>EJERCICIO ARRAY MULTIDIMENSIONALES EJ5</TITLE> </HEAD>
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
$tabla = "<table>";
for ($fila = 0; $fila < 5; $fila++) {
	$tabla .= "<tr>";
	for ($col = 0; $col < 3; $col++) {
		$matriz[$fila][$col] = ($fila+1) + ($col + 1);
		$tabla .= "<td>".$matriz[$fila][$col]."</td>";
	}
	$tabla .= "</tr>";
}
$tabla .= "</table>";
var_dump($matriz);
echo $tabla;
?>
</BODY>
</HTML>