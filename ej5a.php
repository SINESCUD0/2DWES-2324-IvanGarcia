<HTML>
<HEAD> <TITLE>EJERCICIO ARRAY UNIDIMENSIONALES EJ5</TITLE> </HEAD>

<BODY>
<?php
$array1 = array("Bases Datos", "Entornos Desarrollo", "Programación");
$array2 = array("Sistemas Informaticos", "Fol", "Mecanizado");
$array3 = array("Desarrollo Web ES","Desarrollo Web EC","Despliegue","Desarrollo Interfaces", "Inglés");
$arrays[] = $array1;
$arrays[] = $array2;
$arrays[] = $array3;
var_dump($arrays);
$resultado = array_merge($array1, $array2, $array3);
var_dump($resultado);
array_push($array1,$array2,$array3);
var_dump($array1);
?>
</BODY>
</HTML>