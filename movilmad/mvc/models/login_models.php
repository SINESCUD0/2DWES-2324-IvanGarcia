<?php
require_once $_SERVER['DOCUMENT_ROOT']."/movilmad/mvc/db/db.php";
function obtenerCliente($username,$password) {
	global $conexion;
	try {
		$obtenerInfo = $conexion->prepare("SELECT * FROM RCLIENTES WHERE email = :user AND idcliente = :password AND pendiente_pago = 0 AND fecha_baja IS NULL;");
		$obtenerInfo->bindParam(':user', $username);
		$obtenerInfo->bindParam(':password', $password);
		$obtenerInfo->execute();
		if($obtenerInfo->fetch(PDO::FETCH_OBJ)){
			return true;
		}else{
			return false;
		} 

	} catch (PDOException $ex) {
		echo $ex->getMessage();
		return false;
	}
}
?>