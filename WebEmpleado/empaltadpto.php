<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$nombre = test_input($_POST['nombre']);
	
	$servername = "localhost";
	$username = "root";
	$password = "rootroot";
	$dbname = "webemple";

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		insert_departamento($conn,$nombre);

		echo "New records created successfully";
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

function insert_departamento($conn,$nombre){
	$id = '';
	$stmt = $conn->prepare("SELECT COUNT(cod_dpto) AS NUMERO_COD FROM departamento");
    $stmt->execute();
	
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$resultado=$stmt->fetchAll();
	
	foreach($resultado as $row){
        $cont = $row['NUMERO_COD'] + 1;
		$num = str_pad($cont, 3, '0', STR_PAD_LEFT);
        $id = "D" . $num;
    }
	
	$stmt = $conn->prepare("INSERT INTO departamento (cod_dpto,nombre_dpto) VALUES (:id,:nombre)");
	$stmt->bindParam(':id', $id);
	$stmt->bindParam(':nombre', $nombre);
	$stmt->execute();
}
?>