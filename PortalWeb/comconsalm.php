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
<h1>CONSULTA ALMACEN</h1>
<form name='mi_formulario' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
Nombre Almacen:
<select name="almacen">
<?php
	$servername = "localhost";
	$username = "root";
	$password = "rootroot";
	$dbname = "COMPRASWEB";
	
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$array = array();
		$array = cargar_almacen($conn);
		
		foreach ($array as $id => $localidad) {
			echo "<option value=\"$id\">$localidad</option>";
		}
		
	}catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
	$conn = null;
?>
</select>
<br/><br/>
<input type="submit" value="Consulta">
<input type="reset" value="Borrar">
</FORM>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$almacen = test_input($_POST['almacen']);

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		consulta_almacen($conn,$almacen);
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

function consulta_almacen($conn,$almacen){
	$stmt = $conn->prepare("SELECT * FROM ALMACENA WHERE NUM_ALMACEN = :id");
	$stmt->bindParam(':id',$almacen);
	$stmt->execute();
	
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$resultado=$stmt->fetchAll();
	
	foreach($resultado as $row) {
		$stmt = $conn->prepare("SELECT NOMBRE FROM PRODUCTO WHERE ID_PRODUCTO = :id_producto");
		$stmt->bindParam(':id_producto',$row['ID_PRODUCTO']);
		$stmt->execute();
		
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$resultado2=$stmt->fetchAll();
		foreach($resultado2 as $row2) {
			$array1[$row2['NOMBRE']] = $row['CANTIDAD'];
		}
		$stmt = $conn->prepare("SELECT LOCALIDAD FROM ALMACEN WHERE NUM_ALMACEN = :almacen");
		$stmt->bindParam(':almacen',$row['NUM_ALMACEN']);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$resultado3=$stmt->fetchAll();
		foreach($resultado3 as $row3) {
			$array[$row3['LOCALIDAD']] = $array1;
		}
	}
	if(empty($array1)){
		$stmt = $conn->prepare("SELECT LOCALIDAD FROM ALMACEN WHERE NUM_ALMACEN = :almacen");
		$stmt->bindParam(':almacen',$almacen);
		$stmt->execute();
		
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$resultado=$stmt->fetchAll();
		foreach($resultado as $row) {
			echo "No hay productos en el almacen de " . $row['LOCALIDAD'];
		}
	}else{
		$tabla = "<table><tr><td>Producto</td><td>Cantidad</td></tr>";
		foreach($array as $l => $c){
			echo "El almacen de " . $l . ":<br/>";
			foreach($c as $id_producto => $stock){
				$tabla .= "<tr><td>".$id_producto."</td><td>".$stock."</td></tr>";
			}
		}
		$tabla .= "</table>";
		echo $tabla;
	}
}

function cargar_almacen($conn){
	$stmt = $conn->prepare("SELECT * FROM ALMACEN");
	$stmt->execute();
	
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$resultado=$stmt->fetchAll();
	foreach($resultado as $row) {
		$array[$row['NUM_ALMACEN']] = $row['LOCALIDAD'];
	}
	return $array;
}
?>
</FORM>
</BODY>
</HTML>