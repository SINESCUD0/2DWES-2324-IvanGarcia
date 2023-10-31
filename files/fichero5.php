<HTML>
<HEAD> <TITLE>FICHERO 5</TITLE>
</HEAD>
<BODY>
<h1>Operaciones Ficheros</h1>
<form name='mi_formulario' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
Fichero(Path/nombre):
<input type='textarea' name='fichero' value=''><br/>
Operaciones:<br/>
<input type='radio' name='operacion' value='mostrar'/>Mostrar Fichero<br/>
<input type='radio' name='operacion' value='mostrarlinea'>Mostrar linea <input type='number' name='linea1' value='' style='width:40px;'/></input><br/>
<input type='radio' name='operacion' value='mostrarprimeras'/>Mostrar <input type='number' name='linea2' value='' style='width:40px;' /> primeras lineas</input><br/>
<br/>
<input type="submit" value="enviar">
<input type="reset" value="borrar">
</FORM>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$fichero = test_input($_POST['fichero']);
	$operacion = test_input($_POST['operacion']);
	echo "<h1>Operaciones Ficheros</h1>";
	switch($operacion){
		case 'mostrarlinea':
			$li = test_input($_POST['linea1']);
			operacion($fichero,$operacion,$li);
			break;
		case 'mostrarprimeras':
			$li = test_input($_POST['linea2']);
			operacion($fichero,$operacion,$li);
			break;
		case 'mostrar':
			operacion($fichero,$operacion, 0);
			break;
	}
}

function operacion($fichero,$opcion,$linea){
	if(file_exists($fichero)){
		switch($opcion){
			case 'mostrar':
				$f1 = fopen($fichero, "r");
				while(!feof($f1)){
					$z=fgets($f1,160);
					echo $z,"<br/>";
				}
				break;
			case 'mostrarlinea':
				$f1 = file($fichero);
				$l = $linea - 1;
				foreach($f1 as $linea=>$texto) {
					if($linea == $l){
						echo $texto."<br/>";
						break;
					}
				};
				break;
			case 'mostrarprimeras':
				$f1 = file($fichero);
				$l = $linea - 1;
				foreach($f1 as $linea=>$texto) {
					echo $texto."<br/>";
					if($linea == $l){
						break;
					}
				}
				break;
		}
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