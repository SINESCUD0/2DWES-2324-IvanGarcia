<?php
require_once $_SERVER['DOCUMENT_ROOT']."/movilmad/mvc/models/welcome_models.php";
$nombre;
$apellido;
$id;
$array = array();
$tabla = "";
if(!isset($_COOKIE['login'])) {
	header('location:http://192.168.206.222/movilmad/mvc/controllers/movlogin.php');
	exit();
}else{
	$_username = trim($_COOKIE['login']);
	$_resultado = obtenerInformacion($_username);
	$nombre = $_resultado[0];
	$apellido = $_resultado[1];
	$id = $_resultado[2];
}
require_once $_SERVER['DOCUMENT_ROOT']."/movilmad/mvc/views/movconsultar.php";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(isset($_POST['consultar'])){
		$fechaDesde = $_POST['fechadesde'];
		$fechaHasta = $_POST['fechahasta'];
		$array = datosAlquileres($fechaDesde,$fechaHasta,$id);
		mostrarTablaConsulta($array);
	}elseif(isset($_POST['volver'])){
		header('location:http://192.168.206.222/movilmad/mvc/controllers/movwelcome.php');
		exit();
	}
}
if (isset($_GET['accion']) && $_GET['accion'] == 'eliminar') {
	setcookie("login","",-1,"/");
	header('location:http://192.168.206.222/movilmad/mvc/controllers/movlogin.php');
	exit();
}
?>