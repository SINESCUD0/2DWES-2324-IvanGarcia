<HTML>
<HEAD> <TITLE>IPs</TITLE>
</HEAD>
<BODY>
<h1>IPs</h1>
<form name='mi_formulario' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
IP notacion decimal:
<input type='text' name='ip' value=''></br></br>
<input type="submit" value="Notacion Binaria">
<input type="reset" value="borrar">
</FORM>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$ip = test_input($_POST['ip']);

	echo "<h1> IPs </h1>";
	echo "IP notacion decimal: $ip<br/>";
	$binario = ipBinario($ip);
	echo "IP Binario: $binario";

}

function ipBinario($data){
	$resultado = "";
	$octeto = explode(".",$data);
	foreach($octeto as $octetos){
		$resultado .=str_pad(decbin($octetos), 8, "0", STR_PAD_LEFT) . ".";
	}
	$resultado = substr($resultado, 0 ,-1);
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
