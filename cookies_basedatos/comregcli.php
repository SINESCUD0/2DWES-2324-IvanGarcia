<HTML>
<HEAD> <TITLE>Base Datos</TITLE>
</HEAD>
<BODY>
<h1>ALTA CLIENTES</h1>
<form name='mi_formulario' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
NIF Cliente:
<input type='text' name='nif' value=''></br></br>
Nombre Cliente:
<input type='text' name='nombre' value=''></br></br>
Apellido Cliente:
<input type='text' name='apellido' value=''></br></br>
Codigo postal Cliente:
<input type='number' name='cp' value=''></br></br>
Direccion Cliente:
<input type='text' name='direccion' value=''></br></br>
Ciudad Cliente:
<input type='text' name='ciudad' value=''></br></br>
<input type="submit" value="Crear">
<input type="reset" value="Borrar">
</FORM>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$nif = test_input($_POST['nif']);
	$nombre = test_input($_POST['nombre']);
	$apellido = test_input($_POST['apellido']);
	$cp = test_input($_POST['cp']);
	$direccion = test_input($_POST['direccion']);
	$ciudad = test_input($_POST['ciudad']);

	try {
		$conn = conexion();
		insert_cliente($conn,$nif,$nombre,$apellido,$cp,$direccion,$ciudad);
		
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

function conexion(){
	$servername = "localhost";
	$username = "root";
	$password = "rootroot";
	$dbname = "COMPRASWEB";
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $conn;
}

function insert_cliente($conn,$nif,$nombre,$apellido,$cp,$direccion,$ciudad){
	$stmt = $conn->prepare("SELECT NIF FROM CLIENTE WHERE NIF = :nif");
	$stmt->bindParam(':nif', $nif);
    $stmt->execute();
	
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$resultado=$stmt->fetchAll();
	
	if(empty($resultado)){
		if(strlen($nif) === 9){
			$numeros = substr($nif,0,-1);
			$letra = substr($nif,-1);
			if(is_numeric($numeros) && is_string($letra)){
				$stmt = $conn->prepare("INSERT INTO CLIENTE (NIF,NOMBRE,APELLIDO,CP,DIRECCION,CIUDAD) VALUES (:nif,:nombre,:apellido,:cp,:direccion,:ciudad)");
				$stmt->bindParam(':nif', $nif);
				$stmt->bindParam(':nombre', $nombre);
				$stmt->bindParam(':apellido', $apellido);
				$stmt->bindParam(':cp', $cp);
				$stmt->bindParam(':direccion', $direccion);
				$stmt->bindParam(':ciudad', $ciudad);
				$stmt->execute();
				echo "New records created successfully";
			}else{
				throw new Exception("El nif que has introducido no es un nif");
			}
		}else if($nif == ""){
			throw new Exception("El campo nif esta vacio");
		}else if(strlen($nif) < 9){
			throw new Exception("El campo nif no cumple con el tamaño establecido");
		}
	}else{
		throw new Exception("Ya hay un cliente con ese nif");
	}
	
}
?>
</FORM>
</BODY>
</HTML>