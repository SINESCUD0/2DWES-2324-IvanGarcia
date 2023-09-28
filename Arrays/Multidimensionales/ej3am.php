<HTML>
<HEAD> <TITLE>EJERCICIO ARRAY MULTIDIMENSIONALES EJ3</TITLE> </HEAD>
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
$tabla = "<table>";
$tabla2 = "<table>";
foreach($matriz as $fila){
	$tabla .= "<tr>";
	foreach($fila as $elemento){
		$tabla .= "<td>".$elemento."</td>";
	}
	$tabla .= "</tr>";
}
echo $tabla."</table><br/>";
for ($fila = 0; $fila < 5; $fila++) {
	$tabla2 .= "<tr>";
    for ($col = 0; $col < 3; $col++) {
        $tabla2 .= "<td>".$matriz[$col][$fila]."</td>";
    }
    $tabla2 .= "</tr>";
}
echo $tabla2."</table>";
?>
</BODY>
</HTML>