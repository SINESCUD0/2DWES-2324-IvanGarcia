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
$numdatos=count($matriz);
$numMay = 0;
$fi = 0;
$co = 0;
$tabla = "<table>";
foreach($matriz as $fila){
	$tabla .= "<tr>";
	foreach($fila as $elemento){
		if($numMay < $elemento){
			$numMay = $elemento;
			//$fi = $fila;
			//$co = $col;
		}
		$tabla .= "<td>".$elemento."</td>";
	}
	$tabla .= "</tr>";
}
/*for ($fila = 0; $fila < $numdatos; $fila++) {
	$tabla .= "<tr>";
	for ($col = 0; $col < $numdatos; $col++) {
		$tabla .= "<td>".$matriz[$fila][$col]."</td>";
		if($numMay < $matriz[$fila][$col]){
			$numMay = $matriz[$fila][$col];
			$fi = $fila;
			$co = $col;
		}
	}
	$tabla .= "</tr>";
}*/
$tabla .= "</table>";
echo $tabla;
echo "Numero mayor = $numMay que esta en la fila $fi y la columna $co";
?>
</BODY>
</HTML>