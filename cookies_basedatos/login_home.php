<!DOCTYPE html>
<html>
<body>
<form name='mi_formulario' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
<?php
$cookie_name="usuario";
if(!isset($_COOKIE[$cookie_name])) {
	echo "Cookie " . $cookie_name . " no definida!!!<br>";
}else{
	echo "BIENVENIDO: " . $_COOKIE[$cookie_name];
	echo "<br/><a href='compro.php'>Compra de Productos</a>";
	echo "<br/><a href='comconscom.php'>Consulta de Compras</a><br/>";
}
?>
<input type="submit" name="cerrar" value="cerrar"/>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	setcookie("nif","",time() - 3600,"/");
	setcookie("usuario","",time() - 3600,"/");
	setcookie("clave","",time() - 3600,"/");
	header("Location: comlogincli.php");
    exit();
}
?>
</body>
</html> 
