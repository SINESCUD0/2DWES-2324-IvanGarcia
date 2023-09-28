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
$arrayFilas = array();
$arrayColumnas = array();
$numdatos=count($multiplos);
$sumFilas = 0;
$sumColumnas = 0;
$tabla1 = "<table>";
$tabla2 = "<table>";
for ($col = 0; $col < 3; $col++) {
	for ($fila = 0; $fila < $numdatos; $fila++) {
		$sumFilas += $multiplos[$fila][$col];
	}
	$arrayFilas[] = $sumFilas;
	$sumFilas = 0;
}
for ($fila = 0; $fila < $numdatos; $fila++) {
	for ($col = 0; $col < 3; $col++) {
		$sumColumnas += $multiplos[$fila][$col];
	}
	$arrayColumnas[] = $sumColumnas;
	$sumColumnas = 0;
}
foreach($arrayFilas as $fila){
	$tabla1 .= "<td>".$fila."</td>";
}
foreach($arrayColumnas as $columnas){
	$tabla2 .= "<tr><td>".$columnas."</td></tr>";
}
var_dump($arrayFilas);
var_dump($arrayColumnas);
echo $tabla1."</table>"."<br/>";
echo $tabla2."</table>";
?>
</BODY>
</HTML>