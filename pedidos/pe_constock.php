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
<label>Linea de producto:</label>
<select name="linea">
<?php
try {
	$conn = conexion();
	$array = array();
	$array = cargar_producto_stock_linea($conn);
	mostrar_selects2($array);
}catch(PDOException $e){
	echo "Error: " . $e->getMessage();
}
$conn = null;
?>
</select>
<input type="submit" name="consulta" value="consultar"/>
<a href="pe_inicio.php"><input type="button" value="Atras" /></a>
<br/><br/>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$linea = test_input($_POST['linea']);
	try{
		$conn = conexion();
		$array_linea = linea_stock($conn,$linea);
		$tabla = mostrar_stock($array_linea);
		echo $tabla;
	}catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
	$conn = null;
}
?>
</body>
</html> 