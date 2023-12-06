<HTML>
<HEAD> <TITLE>Base Datos</TITLE>
</HEAD>
<BODY>
<h1>ALTA ALMACEN</h1>
<form name='mi_formulario' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
Localidad del Almacen:
<input type='text' name='localidad' value=''></br></br>
<input type="submit" value="Crear">
<input type="reset" value="Borrar">
</FORM>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$localidad = test_input($_POST['localidad']);
	
	$servername = "localhost";
	$username = "root";
	$password = "rootroot";
	$dbname = "COMPRASWEB";

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		insert_almacen($conn,$localidad);

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

function insert_almacen($conn,$localidad){
	$stmt = $conn->prepare("INSERT INTO ALMACEN (LOCALIDAD) VALUES (:localidad)");
	$stmt->bindParam(':localidad', $localidad);
	$stmt->execute();
}
?>
</FORM>
</BODY>
</HTML>