<HTML>
<HEAD> <TITLE>EJERCICIO ARRAY UNIDIMENSIONALES EJ6</TITLE> </HEAD>

<BODY>
<?php
$array1 = array("Bases Datos", "Entornos Desarrollo", "Programación");
$array2 = array("Sistemas Informaticos", "Fol", "Mecanizado");
$array3 = array("Desarrollo Web ES","Desarrollo Web EC","Despliegue","Desarrollo Interfaces", "Inglés");

unset($array2[2]);

$arrays[] = array_reverse($array1);
$arrays[] = array_reverse($array2);
$arrays[] = array_reverse($array3);

var_dump(array_reverse($arrays));
$resultado = array_merge($array1, $array2, $array3);
var_dump(array_reverse($resultado));
$resultado1 = array();
array_push($resultado1,array_reverse($array1),array_reverse($array2),array_reverse($array3));
var_dump(array_reverse($resultado1));
?>
</BODY>
</HTML>