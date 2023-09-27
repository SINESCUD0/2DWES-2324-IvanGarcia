<HTML>
<HEAD> <TITLE>EJERCICIO ARRAY MULTIDIMENSIONALES EJ1</TITLE> </HEAD>
<STYLE>
table {
  border-collapse: collapse;
}
td{
  border: 1px solid black;
  text-align: left;
  padding: 8px;
}
</STYLE>
<BODY>
<?php
$multiplos = array(array(2,4,6), array(8,10,12), array(14,16,18));
$numdatos=count($multiplos);
$tabla = "<table>";
for ($fila = 0; $fila < $numdatos; $fila++) {
	$tabla .= "<tr>";
	for ($col = 0; $col < 3; $col++) {
		$tabla .= "<td>".$multiplos[$fila][$col]."</td>";
	}
	$tabla .= "</tr>";
}
echo $tabla."</table>";
?>
</BODY>
</HTML>