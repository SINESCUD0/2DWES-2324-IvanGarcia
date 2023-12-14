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
<h1>MODIFICAR SALARIO EMPLEADO</h1>
<form name='mi_formulario' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
DNI:
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
</select>
<br/><br/>
Aumentar o disminuir salario:
<input type="number" name="salario" min="-100" max="100"><br/><br/>
<input type="submit" value="MODIFICAR">
<input type="reset" value="Borrar">
</FORM>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$dni = test_input($_POST['dni']);
	$salario = test_input($_POST['salario']);
	
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		update_empleado($conn,$dni,$salario);
		
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

function cargar_dni($conn){
	$stmt = $conn->prepare("SELECT dni FROM empleado");
	$stmt->execute();
	
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$resultado=$stmt->fetchAll();
	foreach($resultado as $row) {
		$array[] = $row['dni'];
	}
	return $array;
}

function update_empleado($conn, $dni, $salario){
	$stmt = $conn->prepare("UPDATE empleado SET salario = ROUND(salario+(salario*(:salario/100)),2) WHERE dni = :dni");
	$stmt->bindParam(':dni', $dni);
	$stmt->bindParam(':salario', $salario);
	$stmt->execute();
}
?>
</FORM>
</BODY>
</HTML>