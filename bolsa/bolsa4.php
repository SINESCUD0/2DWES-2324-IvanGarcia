<HTML>
<HEAD> <TITLE>BOLSA 4</TITLE>
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
<select name="miSelect">
<?php
	$array = array();
	$array = cargar();

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
Mostrar:
<select name="campo">
<?php
	$array = array();
	$array = cargar2();
	$opciones = "";
	function cargar2(){
		$f1=file("ibex35.txt");
		foreach($f1 as $texto) {
			$filas = preg_split('/\s{2,}/', trim($texto));
			if($filas[0] == "Valor"){
				foreach($filas as $columna){
					if($columna != "Hora" && $columna != "Valor"){
						$array[] = $columna;
					}
				}
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
		$valor2 = $_POST['campo'];
		busqueda($valor, $valor2);
	}

	function busqueda($valor, $valor2){
		$f1=file("ibex35.txt");
		$x = 0;
		foreach($f1 as $texto) {
			$filas = preg_split('/\s{2,}/', trim($texto));
			for($i = 1; $i < 9; $i++){
				if($filas[$i] == $valor2){
					$x = $i;
					
				}
			}
			if($filas[0] == $valor){
				echo "El valor $valor2 de $valor es $filas[$x]";
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