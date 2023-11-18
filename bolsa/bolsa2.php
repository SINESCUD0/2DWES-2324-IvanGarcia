<HTML>
<HEAD> <TITLE>BOLSA 2</TITLE>
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
Valor bursatil:
<input type='textarea' name='valor' value=''><br/>
<input type="submit" value="Ver Datos">
<input type="reset" value="borrar">
</FORM>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$valor = test_input($_POST['valor']);
	busqueda($valor);
}

function busqueda($valor){
	$f1=file("ibex35.txt");
	$tabla = "<table>";
	$x = 0;
	echo "<h1>Valor a buscar</h1>";
	foreach($f1 as $texto) {
		$filas = preg_split('/\s{2,}/', trim($texto));
		$tabla .= "<tr>";
		if($filas[0] == $valor){
			foreach($filas as $columna){
				$tabla .= "<td>$columna</td>";
			}
		}
		$x++;
		$tabla .= "</tr>";
	}
	echo $tabla."</table>";
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