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
<h1>EMPLEADOS DEPARTAMENTO FECHA</h1>
<form name='mi_formulario' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
Fecha:
<input type="date" name="fecha">
<br/><br/>
<input type="submit" value="Ver Empleados/Departamentos">
<input type="reset" value="Borrar">
</FORM>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$servername = "localhost";
	$username = "root";
	$password = "rootroot";
	$dbname = "webemple";
	
	$fecha = test_input($_POST['fecha']);
	
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$array = array();
		$array = cargar_empleados($conn,$fecha);
		
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

function cargar_empleados($conn, $fecha){
	$array = array();
	$stmt = $conn->prepare("SELECT dni, cod_dpto FROM emple_depart WHERE fecha_ini >= :fecha AND fecha_fin <= :fecha");
	$stmt->bindParam(":fecha",$fecha);
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
			$stmt = $conn->prepare("SELECT nombre_dpto FROM departamento WHERE cod_dpto = :codigo");
			$codigo = $row['cod_dpto'];
			$stmt->bindParam(":codigo",$codigo);
			$stmt->execute();
			
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			$resultado3=$stmt->fetchAll();
			foreach($resultado3 as $row3){
				$array[$row['dni']] = [$row2['nombre'],$row2['apellidos'],$row3['nombre_dpto']];
			}
		}
	}
	return $array;
}

function mostrar_tabla($array){
	if(!empty($array)){
		$tabla = "<table><tr><td>DNI</td><td>NOMBRE</td><td>APELLIDOS</td><td>DEPARTAMENTO</td></tr>";
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
		$resultado = "No hay empleados que trabajaran en esa fecha";
		return $resultado;
	}
}
?>
</FORM>
</BODY>
</HTML>