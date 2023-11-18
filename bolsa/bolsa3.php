<HTML>
<HEAD> <TITLE>BOLSA 3</TITLE>
</HEAD>
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
<form name='mi_formulario' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
<h1>Consulta Operaciones Bolsa</h1>
Valores:
<select name="miSelect" id="miSelect">
<?php
	$array = array();
	$array = cargar();
	var_dump($array);

	function cargar(){
		$f1=file("ibex35.txt");
		foreach($f1 as $texto) {
			$filas = preg_split('/\s{2,}/', trim($texto));
			if($filas[0] != "Valor"){
				$array[] = $filas[0];
			}
		}
		return $array;
	}
	
	foreach ($array as $opcion) {
        echo "<option value=\"$opcion\">$opcion</option>";
    }
?>
</select>
<br/>
<br/>
<input type="submit" value="Visualizar">
<input type="reset" value="borrar">
</form>
<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$valor = $_POST['miSelect'];
		busqueda($valor);
	}

	function busqueda($valor){
		$f1=file("ibex35.txt");
		
		foreach($f1 as $texto) {
			$filas = preg_split('/\s{2,}/', trim($texto));
			if($filas[0] == $valor){
				echo "El valor Cotizacion de $valor es $filas[1]<br/>";
				echo "Cotizacion Maxima de $valor es $filas[5]<br/>";
				echo "Cotizacion Minima de $valor es $filas[6]<br/>";
			}
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