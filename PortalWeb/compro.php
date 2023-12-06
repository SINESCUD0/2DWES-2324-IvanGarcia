<HTML>
<HEAD> <TITLE>Base Datos</TITLE>
</HEAD>
<BODY>
<h1>COMPRA PRODUCTOS</h1>
<form name='mi_formulario' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
NIF Cliente:
<input type='text' name='nif' value=''></br></br>
Id Producto:
<input type='text' name='id' value=''></br></br>
<input type="submit" value="Crear">
<input type="reset" value="Borrar">
</FORM>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$nif = test_input($_POST['nif']);
	$producto = test_input($_POST['id']);
	
	$servername = "localhost";
	$username = "root";
	$password = "rootroot";
	$dbname = "COMPRASWEB";

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		insert_compra($conn,$nif,$producto);
		
	}catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}catch(Exception $a){
		echo $a->getMessage();
	}
	$conn = null;
	
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function insert_compra($conn,$nif,$producto){
	$stmt = $conn->prepare("SELECT NIF FROM CLIENTE WHERE NIF = :nif");
	$stmt->bindParam(':nif', $nif);
    $stmt->execute();
	
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$resultado=$stmt->fetchAll();
	
	$stmt = $conn->prepare("SELECT ID_PRODUCTO FROM PRODUCTO WHERE ID_PRODUCTO = :producto");
	$stmt->bindParam(':producto', $producto);
    $stmt->execute();
	
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$resultado2=$stmt->fetchAll();
	
	if(!empty($resultado) && !empty($resultado2)){
		$stmt = $conn->prepare("SELECT ID_PRODUCTO,CANTIDAD FROM ALMACENA WHERE ID_PRODUCTO = :producto && CANTIDAD > 0");
		$stmt->bindParam(':producto', $producto);
		$stmt->execute();
		
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$resultado3=$stmt->fetchAll();
		if(!empty($resultado3)){
			$stmt = $conn->prepare("INSERT INTO COMPRA (NIF,ID_PRODUCTO,FECHA_COMPRA,UNIDADES) VALUES (:nif,:id,CURRENT_DATE,1)");
			$stmt->bindParam(':nif', $nif);
			$stmt->bindParam(':id', $producto);
			$stmt->execute();
			
			$stmt = $conn->prepare("UPDATE ALMACENA SET CANTIDAD = CANTIDAD - 1 WHERE ID_PRODUCTO = :id");
			$stmt->bindParam(':id', $producto);
			$stmt->execute();
			
			echo "New records created successfully";
			
		}else{
			throw new Exception("No hay suficientes productos");
		}
	}else if(!empty($resultado) && empty($resultado2)){
		throw new Exception("No existe ese producto");
	}else if(empty($resultado) && !empty($resultado2)){
		throw new Exception("No existe ese cliente");
	}else{
		throw new Exception("No existe ese cliente y no existe ese producto");
	}
}
?>
</FORM>
</BODY>
</HTML>