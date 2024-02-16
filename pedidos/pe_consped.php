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
<input type="submit" name="consulta" value="consultar"/>
<a href="pe_inicio.php"><input type="button" value="Atras" /></a>
<br/>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$cliente = test_input($_COOKIE['usuario']);
	try{
		$conn = conexion();
		$array_pedidos = pedidos($conn,$cliente);
		$tabla = mostrar_pedidos($array_pedidos,$cliente);
		echo $tabla;
	}catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
	$conn = null;
}
?>
</body>
</html> 