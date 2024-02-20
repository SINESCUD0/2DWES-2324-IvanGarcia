<?php
require_once $_SERVER['DOCUMENT_ROOT']."/movilmad/mvc/models/welcome_models.php";
$nombre;
$apellido;
$id;
$select;
$array = array();
if(!isset($_COOKIE['login'])) {
	header('location:http://192.168.206.222/movilmad/mvc/controllers/movlogin.php');
	exit();
}else{
	$_username = trim($_COOKIE['login']);
	$_resultado = obtenerInformacion($_username);
	$nombre = $_resultado[0];
	$apellido = $_resultado[1];
	$id = $_resultado[2];
	$select = selectCochesDevolver($id);
}
require_once $_SERVER['DOCUMENT_ROOT']."/movilmad/mvc/views/movdevolver.php";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(isset($_POST['devolver'])){
		$matricula = $_POST["vehiculos"];
		$fecha = date("Y-m-d H:i:s");
		devolverCoche($matricula,$id,$fecha);
		
		echo '<script type="text/javascript">
				document.getElementById("myForm").submit();
			</script>';
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
if(!empty($_GET)){
	include $_SERVER['DOCUMENT_ROOT'].'/movilmad/mvc/models/apiRedsys.php';
	// Se crea Objeto
	$miObj = new RedsysAPI;
	$version = $_GET['Ds_SignatureVersion'];
	$params = $_GET['Ds_MerchantParameters'];
	$signature = $_GET['Ds_Signature'];
	
	
	$decodec = $miObj->decodeMerchantParameters($params);
	
	$codigoRespuesta = $miObj->getParameter("Ds_Response");
	$data = $miObj->getParameter('Ds_MerchantData');
	//var_dump($data);
	$kc = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7'; //Clave recuperada de CANALES
	$firma = $miObj->createMerchantSignatureNotif($kc,$params);
	
	if($codigoRespuesta >= 0 && $codigoRespuesta <= 99){
		echo "OPERACION EXITOSA <br/>";
		confirmarCompra($data);
	}else{
		echo "OPERACION NO EXITOSA";
		cancelarCompra($data);
	}
}
?>