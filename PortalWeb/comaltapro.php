<HTML>
<HEAD> <TITLE>Base Datos</TITLE>
</HEAD>
<BODY>
<h1>ALTA PRODUCTOS</h1>
<form name='mi_formulario' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
Nombre Producto:
<input type='text' name='nombre' value=''></br></br>
Precio Producto:
<input type='text' name='precio' value=''></br></br>
Categoria Producto:
<select name="categoria">
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
		$array = cargar($conn);
		
		foreach ($array as $id => $categoria) {
			echo "<option value=\"$id\">$categoria</option>";
		}
		
	}catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
	$conn = null;

	function cargar($conn){
		$stmt = $conn->prepare("SELECT * FROM CATEGORIA");
		$stmt->execute();
		
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$resultado=$stmt->fetchAll();
		foreach($resultado as $row) {
			$array[$row['ID_CATEGORIA']] = $row['NOMBRE'];
		}
		return $array;
	}
?>
</select>
<br/><br/>
<input type="submit" value="Crear">
<input type="reset" value="Borrar">
</FORM>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$nombre = test_input($_POST['nombre']);
	$precio = test_input($_POST['precio']);
	$idCategoria = test_input($_POST['categoria']);
	
	$servername = "localhost";
	$username = "root";
	$password = "rootroot";
	$dbname = "COMPRASWEB";

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		insert_producto($conn,$nombre,$precio,$idCategoria);

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

function insert_producto($conn,$nombre,$precio,$idCategoria){
	$id = '';
	$stmt = $conn->prepare("SELECT COUNT(ID_PRODUCTO) AS NUMERO_IDS FROM PRODUCTO");
    $stmt->execute();
	
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$resultado=$stmt->fetchAll();
	
	foreach($resultado as $row){
        $cont = $row['NUMERO_IDS'] + 1;
		$num = str_pad($cont, 4, '0', STR_PAD_LEFT);
        $id = "P" . $num;
    }
	
	$stmt = $conn->prepare("INSERT INTO PRODUCTO (ID_PRODUCTO,NOMBRE,PRECIO,ID_CATEGORIA) VALUES (:id,:nombre,:precio,:idCategoria)");
	$stmt->bindParam(':id', $id);
	$stmt->bindParam(':nombre', $nombre);
	$stmt->bindParam(':precio', $precio);
	$stmt->bindParam(':idCategoria', $idCategoria);
	$stmt->execute();
}
?>
</FORM>
</BODY>
</HTML>