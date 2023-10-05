<HTML>
<HEAD> <TITLE>EJERCICIO ARRAY MULTIDIMENSIONALES EJ8</TITLE> </HEAD>
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
$matriz1 = array(
	array(1,2,3),
	array(4,5,6),
	array(7,8,9)
);
$matriz2 = array(
	array(10,11,12),
	array(13,14,15),
	array(16,17,18)
);
$sumaMatrices = array();
$productoMatrices = array();
foreach($matriz1 as $filakey => $fila){
	foreach($fila as $columna => $elemento){
		$sumaMatrices[$filakey][$columna] = $elemento;
	}
}
foreach($matriz2 as $filakey => $fila){
	foreach($fila as $columna => $elemento){
		$sumaMatrices[$filakey][$columna] += $elemento;
	}
}

for($fil1 = 0; $fil1 < 3; $fil1++) {
	$fila = array();
	for($col2 = 0; $col2 < 3; $col2++) {
		$suma = 0;
		for ($f1c2 = 0; $f1c2 < 3; $f1c2++) {
			$suma += $matriz1[$fil1][$f1c2] * $matriz2[$f1c2][$col2];
		}
		$fila[] = $suma;
	}
	$producto[] = $fila;
}
var_dump($sumaMatrices);
var_dump($producto);
?>
</BODY>
</HTML>