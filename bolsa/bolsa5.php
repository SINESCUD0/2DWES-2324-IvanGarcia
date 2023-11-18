<HTML>
<HEAD> <TITLE>BOLSA 5</TITLE>
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
Mostrar:
<select name="miSelect">
	<option value="Volumen" name="Volumen">Total Volumen</option>
	<option value="Capitalizacion" name="Capitalizacion">Total Capitalizacion</option>
</select>
<br/>
<br/>
<br/>
<input type="submit" value="Visualizar">
<input type="reset" value="borrar">
</form>
<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$valor = $_POST['miSelect'];
		total($valor);
	}
	
	//Volumen 6
	//Capitalizacion 7

	function total($valor){
		$f1=file("ibex35.txt");
		$total = 0;
		foreach($f1 as $texto) {
			$filas = preg_split('/\s{2,}/', trim($texto));
			if($filas[0] != "Valor"){
				if($valor == "Volumen"){
					$numero = $filas[7];
					$total += str_replace(".","",$numero);
				}
				else if($valor == "Capitalizacion"){
					$numero = $filas[8];
					$total += str_replace(".","",$numero);
				}
			}
		}
		echo "Total $valor $total";
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