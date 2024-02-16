<?php
include('funciones.php');
iniciada();
?>
<!DOCTYPE html>
<html>
<STYLE>
		td, tr{
			text-align: center; 
			border: 1px solid; 
			width: 150px;
		}
</STYLE>
<body>
<form name='mi_formulario' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
<label>Nombre producto:</label>
<select name="producto">
<?php
try {
	$conn = conexion();
	$array = array();
	$array = cargar_producto_stock($conn);
	mostrar_selects($array);
}catch(PDOException $e){
	echo "Error: " . $e->getMessage();
}
$conn = null;
?>
</select>
<br/><br/>
<input type="submit" name="consulta" value="consultar"/>
<a href="pe_inicio.php"><input type="button" value="Atras" /></a>
<br/><br/>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$producto = test_input($_POST['producto']);
	try{
		$conn = conexion();
		$array_stock = stock($conn,$producto);
		$tabla = mostrar_stock($array_stock);
		echo $tabla;
	}catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
	$conn = null;
}
?>
</body>
</html> 