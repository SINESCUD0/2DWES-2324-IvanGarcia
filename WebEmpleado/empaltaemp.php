<HTML>
<HEAD> <TITLE>Base Datos</TITLE>
</HEAD>
<BODY>
<h1>ALTA EMPLEADO</h1>
<form name='mi_formulario' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
DNI Empleado:
<input type="text" name="dni" value=""><br/><br/>
Nombre Empleado:
<input type="text" name="nombre" value=""><br/><br/>
Apellidos Empleado:
<input type="text" name="apellidos" value=""><br/><br/>
Fecha nacimiento Empleado:
<input type="date" name="fecha" value=""><br/><br/>
Salario Empleado:
<input type="double" name="salario" value=""><br/><br/>
Departamento Empleado:
<select name="departamento">
<?php
	$servername = "localhost";
	$username = "root";
	$password = "rootroot";
	$dbname = "webemple";
	
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$array = array();
		$array = cargar_departamento($conn);
		
		foreach ($array as $id => $nombre) {
			echo "<option value=\"$id\">$nombre</option>";
		}
		
	}catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
	$conn = null;

	
?>
</select>
<br/><br/>
<input type="submit" value="Dar de Alta">
<input type="reset" value="Borrar">
</FORM>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$dni = test_input($_POST['dni']);
	$nombre = test_input($_POST['nombre']);
	$apellidos = test_input($_POST['apellidos']);
	$fecha = test_input($_POST['fecha']);
	$salario = test_input($_POST['salario']);
	$departamento = test_input($_POST['departamento']);
	
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		insert_empleado($conn,$dni,$nombre,$apellidos,$fecha,$salario);
		insert_empleadodepartamento($conn,$departamento,$dni);

		echo "New records created successfully";
	}catch(PDOException $e){
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

function insert_empleado($conn,$dni,$nombre,$apellidos,$fecha,$salario){
	$stmt = $conn->prepare("INSERT INTO empleado (dni,nombre,apellidos,fecha_nac,salario) VALUES (:dni,:nombre,:apellidos,:fecha,:salario)");
	$stmt->bindParam(':dni', $dni);
	$stmt->bindParam(':nombre', $nombre);
	$stmt->bindParam(':apellidos', $apellidos);
	$stmt->bindParam(':fecha', $fecha);
	$stmt->bindParam(':salario', $salario);
	$stmt->execute();
}

function insert_empleadodepartamento($conn,$departamento,$dni){
	$stmt = $conn->prepare("INSERT INTO emple_depart (dni,cod_dpto,fecha_ini) VALUES (:dni,:cod,CURRENT_DATE)");
	$stmt->bindParam(':dni', $dni);
	$stmt->bindParam(':cod', $departamento);
	$stmt->execute();
}

function cargar_departamento($conn){
	$stmt = $conn->prepare("SELECT cod_dpto, nombre_dpto FROM departamento");
	$stmt->execute();
	
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$resultado=$stmt->fetchAll();
	foreach($resultado as $row) {
		$array[$row['cod_dpto']] = $row['nombre_dpto'];
	}
	return $array;
}
?>
</FORM>
</BODY>
</HTML>