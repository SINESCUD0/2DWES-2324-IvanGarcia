<HTML>
<HEAD> <TITLE>EJERCICIO ARRAY MULTIDIMENSIONALES EJ2</TITLE> </HEAD>
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
$multiplos = array(array(2,4,6), array(8,10,12), array(14,16,18));
$numdatos=count($multiplos);
$sumFilas = 0;
$sumColumnas = 0;
$tabla1 = "<table>";
$tabla2 = "<table>";
for ($col = 0; $col < 3; $col++) {
	$tabla1 .= "<td>";
	for ($fila = 0; $fila < $numdatos; $fila++) {
		$sumFilas += $multiplos[$fila][$col];
	}
	$tabla1 .= $sumFilas."</td>";
	$sumFilas = 0;
}
for ($fila = 0; $fila < $numdatos; $fila++) {
	$tabla2 .= "<tr>";
	for ($col = 0; $col < 3; $col++) {
		$sumColumnas += $multiplos[$fila][$col];
	}
	$tabla2 .= "<td>".$sumColumnas."</td>"."</tr>";
	$sumColumnas = 0;
}
echo $tabla1."</table>"."<br/>";
echo $tabla2."</table>";
?>
</BODY>
</HTML>