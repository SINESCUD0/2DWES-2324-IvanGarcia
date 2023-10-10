<?php
echo "
<style>
table {
  border-collapse: collapse;
}
td, tr{
  border: 1px solid black;
  text-align: left;
  padding: 8px;
}
</style>
";
$nombre = test_input($_POST['nombre']);
$apellido1 = test_input($_POST['apellido1']);
$apellido2 = test_input($_POST['apellido2']);
$email = test_input($_POST['email']);
$sexo = test_input($_POST['sexo']);
echo "<h1> Datos Alumnos </h1>";

$tabla = "<table><tr><td>Nombre</td><td>Apellidos</td><td>Email</td><td>Sexo</td></tr>";
$tabla .= "<tr><td>$nombre</td><td>$apellido1 $apellido2</td><td>$email</td><td>$sexo</td>";

$text = "Nombre: ".$nombre." Apellido 1: ".$apellido1." Apellido 2: ".$apellido2." Email: ".$email." Sexo: ".$sexo."\n";

fichero($text);

echo $tabla;

function fichero($texto){
	$fh = fopen("datos.txt", 'a') or die("Se produjo un error al crear el archivo");
	fwrite($fh, $texto) or die("No se pudo escribir en el archivo");
	fclose($fh);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>