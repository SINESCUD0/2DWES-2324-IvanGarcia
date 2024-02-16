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
<label>Inicio: </label><input type="date" name="fecha1" /><br/>
<label>Fin: </label><input type="date" name="fecha2" /><br/>
<input type="submit" name="consulta" value="consultar"/>
<a href="pe_inicio.php"><input type="button" value="Atras" /></a>
<br/><br/>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$fecha1 = test_input($_POST['fecha1']);
	$fecha2 = test_input($_POST['fecha2']);
	$cliente = $_COOKIE['usuario'];
	try{
		$conn = conexion();
		$array_fecha = pagos_fechas($conn,$fecha1,$fecha2,$cliente);
		$tabla = mostrar_pagos_fecha($array_fecha);
		echo $tabla;
	}catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
	$conn = null;
}
?>
</body>
</html> 