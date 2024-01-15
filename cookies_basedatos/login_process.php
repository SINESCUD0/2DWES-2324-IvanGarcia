<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera los datos del formulario
    $username = test_input($_POST["username"]);
    $password = test_input($_POST["password"]);
	$nif = test_input($_POST["nif"]);
	
	try{
		$conn = conexion();
		comprobar_cliente($conn,$username,$password,$nif);
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

function comprobar_cliente($conn,$username,$password,$nif){
	$stmt = $conn->prepare("SELECT NOMBRE, APELLIDO FROM CLIENTE WHERE NOMBRE = :username AND APELLIDO = :password AND NIF = :nif");
	$stmt->bindParam(':username', $username);
	$stmt->bindParam(':password', strrev($password));
	$stmt->bindParam(':nif',$nif);
    $stmt->execute();
	
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$resultado=$stmt->fetchAll();
	
	if(!empty($resultado)){
		setcookie("usuario",strtolower($username),time() + 3600,"/");
		//setcookie("clave",strrev(strtolower($password)),time() + 3600,"/");
		setcookie("nif",$nif,time() + 3600,"/");
		header("Location: login_home.php");
		exit();
	}else{
		throw new Exception("Las credenciales son incorrectas");
	}
}
?>

