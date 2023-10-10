<HTML>
<HEAD> <TITLE>CONVERSOR BINARIO</TITLE>
</HEAD>
<BODY>
<h1>CONVERSOR BINARIO</h1>
<form name='mi_formulario' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
Numero decimal:
<input type='number' name='decimal' value=''><br>
<input type="submit" value="enviar">
<input type="reset" value="borrar">
</FORM>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$decimal = test_input($_POST['decimal']);
	echo "<h1> CONVERSOR BINARIO </h1>";
	echo "Numero decimal: $decimal <br/>";

	$binario = pasarBinario($decimal);
	echo "Numero binario: $binario";

}

function pasarBinario($num){
	$resultado = "";
	while($num != 0){
		$resultado .= intval($num) % 2;
		$num = intval($num)/2;
	}
	$resultado = strrev($resultado);
	if($resultado[0] == 0){
		$resultado = substr($resultado,1); 
	}
	return $resultado;
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
