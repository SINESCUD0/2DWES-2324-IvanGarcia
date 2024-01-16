<?php
include('funciones.php');
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
?>

