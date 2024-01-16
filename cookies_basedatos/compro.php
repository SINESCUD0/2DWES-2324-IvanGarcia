<HTML>
<HEAD> <TITLE>Base Datos</TITLE>
<STYLE>
td, tr{
	text-align: center; 
	border: 1px solid; 
	width: 150px;
}
</STYLE>
</HEAD>
<BODY>
<h1>COMPRA PRODUCTOS</h1>
<form name='mi_formulario' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
Id Producto:
<select name="producto">
<?php
	include('funciones.php');
	iniciada();
	try {
		$conn = conexion();
		$array = array();
		$array = cargar_producto($conn);
		foreach ($array as $id => $nombre) {
			echo "<option value=\"$id\">$nombre</option>";
		}
	}catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
	$conn = null;
?>
</select>
</br></br>
Cantidad:
<input type="number" name="cantidad"/>
<br/><br/>
<input type="submit" value="Add Cesta" name="add"/>
<input type="submit" value="Finalizar Compra" name="end">
<a href="login_home.php"><input type="button" value="Volver Al Inicio" /></a>
</FORM>
<?php
//session_start();
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])){
	$cookie_name = "array";
	$conn = conexion();
	$producto = test_input($_POST['producto']);
	$cantidad = test_input($_POST['cantidad']);
	//$array = add_cesta_session($conn,$producto,$cantidad);
	$array = add_cesta_cookie($conn,$producto,$cantidad,$cookie_name);
	$tabla = mostrar_cesta($conn,$array);
	echo $tabla;
	var_dump($array);
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['end'])){
	$nif = test_input($_COOKIE['nif']);
	try {
		$conn = conexion();
		$array = unserialize($_COOKIE["array"]);
		//$array = $_SESSION['array'];
		insert_compra($conn,$nif,$array);
	}catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}catch(Exception $a){
		echo $a->getMessage();
	}
	$conn = null;
}
?>
</FORM>
</BODY>
</HTML>