<HTML>
<HEAD> <TITLE>FICHERO 6</TITLE>
</HEAD>
<BODY>
<h1>Operaciones Ficheros</h1>
<form name='mi_formulario' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
Fichero(Path/nombre):
<input type='textarea' name='fichero' value=''><br/>
<input type="submit" value="Ver Datos Fichero">
<input type="reset" value="borrar">
</FORM>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$fichero = test_input($_POST['fichero']);
	echo "<h1>Operaciones Ficheros</h1>";
	datos_fichero($fichero);
}

function datos_fichero($fichero){
	if(file_exists($fichero)){
		clearstatcache();
		$nombre = basename($fichero);
		$directorio = dirname($fichero);
		$tamano = filesize($fichero);
		$fecha = date("d/m/Y H:i:s", filectime($fichero));
		echo "Nombre del fichero: ".$nombre."<br/>";
		echo "Directorio: ".$directorio."<br/>";
		echo "Tamano del fichero: ".$tamano." bytes<br/>";
		echo "Fecha ultima modificacion fichero: ".$fecha."<br/>";
	}else{
		echo "El fichero no existe";
	}
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