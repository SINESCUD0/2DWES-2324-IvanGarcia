<HTML>
<HEAD> <TITLE>FICHERO 7</TITLE>
</HEAD>
<BODY>
<h1>Operaciones Sistema Ficheros</h1>
<form name='mi_formulario' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
Fichero Origen(Path/nombre):
<input type='textarea' name='ficheroorigen' value=''><br/>
Fichero Destino(Path/nombre):
<input type='textarea' name='ficherodestino' value=''><br/>
Operaciones:<br/>
<input type='radio' checked name='operacion' value='copiar'/>Copiar Fichero<br/>
<input type='radio' name='operacion' value='renombrar'/>Renombrar Fichero<br/>
<input type='radio' name='operacion' value='borrar'/>Borrar Fichero<br/>
<br/>
<input type="submit" value="Ejecutar Operacion">
<input type="reset" value="borrar">
</FORM>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$ficheroOrigen = $_POST['ficheroorigen'];
	$ficheroDestino = $_POST['ficherodestino'];
	$operacion = $_POST['operacion'];
	echo "<h1>Operaciones Sistema Ficheros</h1>";
	operaciones($ficheroOrigen, $ficheroDestino, $operacion);
}

function operaciones($origen, $destino, $opcion){
	if(file_exists($origen)){
		chdir("C:\\");
		switch($opcion){
			case 'copiar':
				if(file_exists(dirname($destino))){
					copy($origen,$destino);
					echo "Se ha copiado el fichero $origen correctamente a $destino";
					break;
				}else{
					echo "El directorio $destino NO existe <br/>";
					mkdir(dirname($destino));
					echo "Se ha creado el directorio $destino <br/>";
					copy($origen,$destino);
					echo "Se ha copiado el fichero correctamente";
					break;
				}
			case 'renombrar':
				if(file_exists(dirname($destino))){
					rename($origen,$destino);
					echo "Se ha renombrado con exito el fichero $origen a $destino";
					break;
				}else{
					echo "El directorio $destino NO existe <br/>";
					mkdir(dirname($destino));
					echo "Se ha creado el directorio $destino <br/>";
					rename($origen,$destino);
					echo "Se ha renombrado con exito el fichero $origen a $destino";
					break;
				}
			case 'borrar':
				unlink($origen);
				echo "Se ha borrado $origen correctamente";
				break;
		}
	}else{
		echo "Fichero $origen no existe";
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