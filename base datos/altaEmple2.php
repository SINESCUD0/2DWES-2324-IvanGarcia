<HTML>
<HEAD> <TITLE>Base Datos</TITLE>
</HEAD>
<BODY>
<h1>ALTA EMPLEADO</h1>
<form name='mi_formulario' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
DNI empleado:
<input type='text' name='dni' value=''></br></br>
Nombre empleado:
<input type='text' name='nombre' value=''></br></br>
Salario empleado:
<input type='number' name='salario' value=''></br></br>
Fecha de nacimiento:
<input type='date' name='fecha' value=''></br></br>
Departamento al que pertenece:
<input type='text' name='codigo' value=''></br></br>
<input type="submit" value="Crear">
<input type="reset" value="Borrar">
</FORM>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$servername = "localhost";
	$username = "root";
	$password = "rootroot";
	$dbname = "empleadosnn";

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// prepare sql and bind parameters
		$stmt = $conn->prepare("INSERT INTO empleado (dni,nombre_emple,salario,fecha_nac) VALUES (:dni,:nombre_emple,:salario,:fecha_nac)");
		$stmt->bindParam(':dni', $dni);
		$stmt->bindParam(':nombre_emple', $nombre);
		$stmt->bindParam(':salario', $salario);
		$stmt->bindParam(':fecha_nac', $fecha);
		
	  
		// insert a row
		$dni = test_input($_POST['dni']);
		$nombre = test_input($_POST['nombre']);
		$salario = test_input($_POST['salario']);
		$fecha = test_input($_POST['fecha']);
		$stmt->execute();
		
		$stmt = $conn->prepare("INSERT INTO emple_dpto (dni,cod_dpto,fecha_ini,fecha_fin) VALUES (:dni,:cod_dpto,CURRENT_DATE,null)");
		$stmt->bindParam(':cod_dpto',$codigo);
		$stmt->bindParam(':dni', $dni);
		$codigo = test_input($_POST['codigo']);
		$stmt->execute();

		echo "New records created successfully";
		}
	catch(PDOException $e)
		{
		echo "Error: " . $e->getMessage();
		}
	$conn = null;
	
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>
</FORM>
</BODY>
</HTML>