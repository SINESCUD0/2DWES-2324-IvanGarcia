<HTML>
<HEAD> <TITLE>Base Datos</TITLE>
</HEAD>
<BODY>
<h1>CAMBIO DEPARTAMENTO EMPLEADO</h1>
<form name='mi_formulario' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
DNI Empleado:
<select name="dni">
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
		$array = cargar_dni($conn);
		
		foreach ($array as $id) {
			echo "<option value=\"$id\">$id</option>";
		}
		
	}catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
	$conn = null;

	
?>
</select><br/><br/>
Nuevo Departamento Empleado:
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
	$departamento = test_input($_POST['departamento']);
	
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		update_empledepart($conn,$dni);
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

function update_empledepart($conn,$dni){
	$stmt = $conn->prepare("UPDATE emple_depart SET fecha_fin = CURRENT_DATE WHERE dni = :dni");
	$stmt->bindParam(':dni', $dni);
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

function cargar_dni($conn){
	$stmt = $conn->prepare("SELECT dni FROM emple_depart");
	$stmt->execute();
	
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$resultado=$stmt->fetchAll();
	foreach($resultado as $row) {
		$array[] = $row['dni'];
	}
	return $array;
}
?>
</FORM>
</BODY>
</HTML>