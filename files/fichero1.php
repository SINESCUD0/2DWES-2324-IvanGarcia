<HTML>
<HEAD> <TITLE>FICHERO 1</TITLE>
</HEAD>
<BODY>
<h1>Datos</h1>
<form name='mi_formulario' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
Nombre:
<input type='textarea' name='nombre' value=''><br>
Apellido 1:
<input type='textarea' name='apellido1' value=''><br>
Apellido 2:
<input type='textarea' name='apellido2' value=''><br>
Fecha Nacimiento:
<input type='date' name='fechanacimiento' value=''><br>
Localidad:
<input type='textarea' name='localidad' value=''><br>
<input type="submit" value="enviar">
<input type="reset" value="borrar">
</FORM>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$nombre = str_pad(test_input($_POST['nombre']),40);
	$apellido1 = str_pad(test_input($_POST['apellido1']),40);
	$apellido2 = str_pad(test_input($_POST['apellido2']),41);
	$fecha = str_pad(test_input($_POST['fechanacimiento']),9);
	$localidad = str_pad(test_input($_POST['localidad']),26);
	crear_fichero($nombre,$apellido1,$apellido2,$fecha,$localidad);
}

function crear_fichero($dato1,$dato2,$dato3,$dato4,$dato5){
	$f1=fopen("alumnos1.txt","a+");
	fwrite($f1,$dato1,40);
	fwrite($f1,$dato2,40);
	fwrite($f1,$dato3,41);
	fwrite($f1,$dato4,10);
	fwrite($f1,$dato5,26);
	fwrite($f1,"\n");
	fclose($f1);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
</BODY>
</HTML>