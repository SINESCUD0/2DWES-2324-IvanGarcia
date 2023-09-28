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
$numMay = null;
$co = 0;
$fi = 0;
$tabla = "<table>";
//rsort($matriz);
foreach($matriz as $fila){
	$tabla .= "<tr>";
	foreach($fila as $elemento){
		$tabla .= "<td>".$elemento."</td>";
	}
	$tabla .= "</tr>";
}
echo $tabla."</table><br/>";
foreach($matriz as $filakey => $fila){
	foreach($fila as $columna => $elemento){
		$ordenado[] = array(
			"numero" => $elemento,
			"fila" => $filakey,
			"columna" => $columna
		);
	}
}
foreach ($ordenado as $elemento) {
    if ($numMay === null || $elemento['numero'] > $numMay) {
        $numMay = $elemento['numero'];
        $fi = $elemento['fila'] + 1;
        $co = $elemento['columna'] + 1;
    }
}
//array_multisort("numero", SORT_ASC,"fila","columna",$ordenado);
//var_dump($ordenado);

/*foreach($matriz as $fila){
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
}*/
$tabla .= "</table>";
//echo $tabla;
echo "Numero mayor = $numMay que esta en la fila $fi y la columna $co";
?>
</BODY>
</HTML>