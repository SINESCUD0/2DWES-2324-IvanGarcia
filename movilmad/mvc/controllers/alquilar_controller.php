<?php
require_once $_SERVER['DOCUMENT_ROOT']."/movilmad/mvc/models/welcome_models.php";
$nombre;
$apellido;
$id;
$fecha;
$select;
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
	$fecha = date("Y-m-d H:i:s");
	$select = selectCoches();
}
require_once $_SERVER['DOCUMENT_ROOT']."/movilmad/mvc/views/movalquilar.php";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(isset($_POST['agregar'])){
		$option = $_POST["vehiculos"];
		$array = addCesta($option);
		$tabla = mostrarTabla($array,$tabla);
		//var_dump($tabla);
	}elseif(isset($_POST['alquilar'])){
		$array = unserialize($_COOKIE['cesta']);
		alquilarCoches($array,$fecha,$id);
		setcookie("cesta","",-1,"/");
	}elseif(isset($_POST['vaciar'])){
		setcookie("cesta","",-1,"/");
	}elseif(isset($_POST['volver'])){
		header('location:http://192.168.206.222/movilmad/mvc/controllers/movwelcome.php');
		exit();
	}
}
?>