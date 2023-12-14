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
<h1>EMPLEADOS DEPARTAMENTOS</h1>
<form name='mi_formulario' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
Departamento:
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
<input type="submit" value="Ver Empleados">
<input type="reset" value="Borrar">
</FORM>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$departamento = test_input($_POST['departamento']);
	
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$array = array();
		$array = cargar_empleados($conn,$departamento);

		$tabla = "";
		$tabla = mostrar_tabla($array);
		echo $tabla;
		
		//echo "New records created successfully";
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

function cargar_empleados($conn, $departamento){
	$array = array();
	$stmt = $conn->prepare("SELECT dni FROM emple_depart WHERE cod_dpto = :departamento AND fecha_fin IS NULL");
	$stmt->bindParam(":departamento",$departamento);
	$stmt->execute();
	
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$resultado=$stmt->fetchAll();
	foreach($resultado as $row) {
		$stmt = $conn->prepare("SELECT nombre, apellidos FROM empleado WHERE dni = :dni");
		$dni = $row['dni'];
		$stmt->bindParam(":dni",$dni);
		$stmt->execute();
	
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$resultado2=$stmt->fetchAll();
		foreach($resultado2 as $row2){
			$array[$row['dni']] = [$row2['nombre'],$row2['apellidos']];
		}
	}
	return $array;
}

function mostrar_tabla($array){
	if(!empty($array)){
		$tabla = "<table><tr><td>DNI</td><td>NOMBRE</td><td>APELLIDOS</td></tr>";
		foreach($array as $dni => $datos){
			$tabla .= "<tr><td>".$dni."</td>";
			foreach($datos as $elemento){
				$tabla .= "<td>".$elemento."</td>";
			}
			$tabla .= "</tr>";
		}
		$tabla .= "</table>";
		return $tabla;
	}else{
		$resultado = "No hay empleados en ese departamento";
		return $resultado;
	}
	
}
?>
</FORM>
</BODY>
</HTML>