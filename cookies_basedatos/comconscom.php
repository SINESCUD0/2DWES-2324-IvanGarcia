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
<h1>CONSULTA COMPRAS</h1>
<form name='mi_formulario' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
Fecha desde:
<input type="date" name="desde">
<br/><br/>
Fecha hasta:
<input type="date" name="hasta">
<br/><br/>
<input type="submit" value="Consulta">
<input type="reset" value="Borrar">
<a href="login_home.php"><input type="button" value="Volver Al Inicio" /></a>
</FORM>
<?php
include('funciones.php');
iniciada();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$nif = test_input($_COOKIE['nif']);
	$fechaIni = test_input($_POST['desde']);
	$fechaFin = test_input($_POST['hasta']);

	try {
		$conn = conexion();
		$mostrar = consulta_almacen($conn,$nif,$fechaIni,$fechaFin);
		mostrar_pantalla($mostrar,$nif);
	}catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
	$conn = null;
	
}
?>
</FORM>
</BODY>
</HTML>