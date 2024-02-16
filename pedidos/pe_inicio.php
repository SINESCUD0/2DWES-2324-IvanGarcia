<?php
include('funciones.php');
iniciada();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	setcookie("usuario","",-1,"/");
	//setcookie("clave","",-1,"/");
	header("Location: pe_login.php");
    exit();
}
?>
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
	echo "<br/><a href='pe_altaped.php'>Compra de Productos</a><br/>";
	echo "<br/><a href='pe_consped.php'>Consulta de Pedidos</a><br/>";
	echo "<br/><a href='pe_conspago.php'>Consulta de Compras</a><br/>";
	echo "<br/><a href='pe_consprodstock.php'>Consulta del Stock de los productos</a><br/>";
	echo "<br/><a href='pe_constock.php'>Consulta del Stock de la linea de productos</a><br/>";
}
?>
<input type="submit" name="cerrar" value="cerrar"/>
</body>
</html> 