<HTML>
<HEAD> <TITLE>CONVERSOR BINARIO</TITLE>
</HEAD>
<BODY>
<h1>CONVERSOR BINARIO</h1>
<form name='mi_formulario' action='binario.php' method='post'>
Numero decimal:
<input type='number' name='decimal' value=''><br>
<input type="submit" value="enviar">
<input type="reset" value="borrar">
</FORM>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$decimal = $_POST['decimal'];
	echo "<h1> CONVERSOR BINARIO </h1>";
	echo "Numero decimal: $decimal <br/>";
	$binario = "";
	$num = $decimal;
	while($num != 0){
		$binario .= intval($num) % 2;
		$num = intval($num)/2;
	}
	$binario = strrev($binario);
	if($binario[0] == 0){
		$binario = substr($binario,1); 
	}
	echo "Numero binario: $binario";
}
?>
</BODY>
</HTML>
