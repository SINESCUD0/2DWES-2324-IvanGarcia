<HTML>
<HEAD> <TITLE>Base Datos</TITLE>
</HEAD>
<BODY>
<h1>CONSULTA STOCK</h1>
<form name='mi_formulario' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
Nombre Producto:
<select name="producto">
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
		$array = cargar_producto($conn);
		
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
<input type="submit" value="Consulta">
<input type="reset" value="Borrar">
</FORM>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$producto = test_input($_POST['producto']);

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		consulta_stock($conn,$producto);
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

function consulta_stock($conn,$producto){
	$stmt = $conn->prepare("SELECT NUM_ALMACEN,CANTIDAD FROM ALMACENA WHERE ID_PRODUCTO = :id");
	$stmt->bindParam(':id',$producto);
	$stmt->execute();
	
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$resultado=$stmt->fetchAll();
	
	foreach($resultado as $row) {
		$stmt = $conn->prepare("SELECT LOCALIDAD FROM ALMACEN WHERE NUM_ALMACEN = :almacen");
		$stmt->bindParam(':almacen',$row['NUM_ALMACEN']);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$resultado2=$stmt->fetchAll();
		foreach($resultado2 as $row2) {
			$array[$row2['LOCALIDAD']] = $row['CANTIDAD'];
		}
	}
	if(empty($array)){
		$stmt = $conn->prepare("SELECT NOMBRE FROM PRODUCTO WHERE ID_PRODUCTO = :id");
		$stmt->bindParam(':id',$producto);
		$stmt->execute();
		
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$resultado=$stmt->fetchAll();
		foreach($resultado as $row) {
			echo "No hay " . $row['NOMBRE'] . " en stock";
		}
	}else{
		foreach($array as $l => $c){
			echo $l . " tiene en stock " . $c;
		}
	}
}

function cargar_producto($conn){
	$stmt = $conn->prepare("SELECT ID_PRODUCTO, NOMBRE FROM PRODUCTO");
	$stmt->execute();
	
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$resultado=$stmt->fetchAll();
	foreach($resultado as $row) {
		$array[$row['ID_PRODUCTO']] = $row['NOMBRE'];
	}
	return $array;
}
?>
</FORM>
</BODY>
</HTML>