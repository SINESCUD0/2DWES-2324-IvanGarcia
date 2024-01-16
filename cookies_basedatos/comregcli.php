<HTML>
<HEAD> <TITLE>Base Datos</TITLE>
</HEAD>
<BODY>
<h1>ALTA CLIENTES</h1>
<form name='mi_formulario' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
NIF Cliente:
<input type='text' name='nif' value=''></br></br>
Nombre Cliente:
<input type='text' name='nombre' value=''></br></br>
Apellido Cliente:
<input type='text' name='apellido' value=''></br></br>
Codigo postal Cliente:
<input type='number' name='cp' value=''></br></br>
Direccion Cliente:
<input type='text' name='direccion' value=''></br></br>
Ciudad Cliente:
<input type='text' name='ciudad' value=''></br></br>
<input type="submit" value="Crear">
<input type="reset" value="Borrar">
</FORM>
<?php
include('funciones.php');
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$nif = test_input($_POST['nif']);
	$nombre = test_input($_POST['nombre']);
	$apellido = test_input($_POST['apellido']);
	$cp = test_input($_POST['cp']);
	$direccion = test_input($_POST['direccion']);
	$ciudad = test_input($_POST['ciudad']);

	try {
		$conn = conexion();
		insert_cliente($conn,$nif,$nombre,$apellido,$cp,$direccion,$ciudad);
		
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