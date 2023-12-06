<HTML>
<HEAD> <TITLE>Base Datos</TITLE>
</HEAD>
<BODY>
<h1>APROVISIONAR PRODUCTOS</h1>
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
</select>
<br/><br/>
Almacen Producto:
<select name="almacen">
<?php
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
</select>
<br/><br/>
Cantidad Productos Almacenados:
<input type="number" name="cantidad" value=""><br/><br/>
<input type="submit" value="Crear">
<input type="reset" value="Borrar">
</FORM>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$almacen = test_input($_POST['almacen']);
	$producto = test_input($_POST['producto']);
	$cantidad = test_input($_POST['cantidad']);
	
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		insert_almacena($conn,$almacen,$producto,$cantidad);

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

function insert_almacena($conn,$almacen,$producto,$cantidad){
	$stmt = $conn->prepare("INSERT INTO ALMACENA (NUM_ALMACEN,ID_PRODUCTO,CANTIDAD) VALUES (:idAlmacen,:idProducto,:cantidad)");
	$stmt->bindParam(':idAlmacen', $almacen);
	$stmt->bindParam(':idProducto', $producto);
	$stmt->bindParam(':cantidad', $cantidad);
	$stmt->execute();
}
?>
</FORM>
</BODY>
</HTML>