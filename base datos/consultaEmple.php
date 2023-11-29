<HTML>
<HEAD> <TITLE>Base Datos</TITLE>
</HEAD>
<BODY>
<h1>CONSULTA EMPLEADOS</h1>
<form name='mi_formulario' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
Codigo Departamento:
<input type='text' name='codigo' value=''></br></br>
<input type="submit" value="Ver">
<input type="reset" value="Borrar">
</FORM>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$servername = "localhost";
	$username = "root";
	$password = "rootroot";
	$dbname = "empleadosnn";
	$codigo = test_input($_POST['codigo']);

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $conn->prepare("SELECT dni, nombre_emple, salario, fecha_nac FROM empleado WHERE dni IN(SELECT dni FROM emple_dpto WHERE cod_dpto = :cod_dpto)");
		$stmt->bindParam(':cod_dpto', $codigo);
		$stmt->execute();

		// set the resulting array to associative
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$resultado=$stmt->fetchAll();
		foreach($resultado as $row) {
			echo "DNI: " . $row["dni"]. " - Nombre: " . $row["nombre_emple"]. "- Salario:" .$row["salario"]. "- Fecha Nacimiento:" .$row["fecha_nac"]. "<br>";
		}
	}catch(PDOException $e)
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