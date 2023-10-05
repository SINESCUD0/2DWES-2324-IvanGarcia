<HTML>
<HEAD> <TITLE>EJERCICIO ARRAY MULTIDIMENSIONALES EJ9</TITLE> </HEAD>
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
$matriz = array(
	array(1,2,3,4),
	array(5,6,7,8),
	array(9,10,11,12)
);
$matrizTranspuesta = array();
$fi = 0;
$co = 0;
$tabla = "<table>";
$tabla2 = "<table>";
foreach($matriz as $fila){
	foreach($fila as $elemento){
		$matrizTranspuesta[$fi][$co] = $elemento;
		$fi++;
		if($fi == 4){
			$fi = 0;
			$co++;
		}
	}
}
foreach($matriz as $fila){
	$tabla .= "<tr>";
	foreach($fila as $elemento){
		$tabla .= "<td>".$elemento."</td>";
	}
	$tabla .= "</tr>";
}
echo $tabla."</table><br/>";
foreach($matrizTranspuesta as $fila){
	$tabla2 .= "<tr>";
	foreach($fila as $elemento){
		$tabla2 .= "<td>".$elemento."</td>";
	}
	$tabla2 .= "</tr>";
}
echo $tabla2."</table>";
var_dump($matriz);
var_dump($matrizTranspuesta);
?>
</BODY>
</HTML>