<?php
require_once $_SERVER['DOCUMENT_ROOT']."/movilmad/mvc/models/welcome_models.php";
$nombre;
$apellido;
$id;
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
if (isset($_GET['accion']) && $_GET['accion'] == 'eliminar') {
	setcookie("login","",-1,"/");
	header('location:http://192.168.206.222/movilmad/mvc/controllers/movlogin.php');
	exit();
}
?>
<html>   
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>Bienvenido a MovilMAD</title>
    <link rel="stylesheet" href="http://192.168.206.222/movilmad/mvc/public/css/bootstrap.min.css">
 </head>
   
 <body>
    <h1>Servicio de ALQUILER DE E-CARS</h1> 
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="container ">
		<!--Aplicacion-->
		<div class="card border-success mb-3" style="max-width: 30rem;">
		<div class="card-header">Menú Usuario - OPERACIONES </div>
		<div class="card-body">


		<B>Bienvenido/a: </B><?php echo $nombre." ".$apellido ?>    <BR><BR>
		<B>Identificador Cliente: </B><?php echo $id ?>  <BR><BR>
	 
		
       <!--Formulario con botones -->
	
		<input type="button" value="Alquilar Vehículo" onclick="window.location.href='alquilar_controller.php'" class="btn btn-warning disabled">
		<input type="button" value="Consultar Alquileres" onclick="window.location.href='movconsultar.php'" class="btn btn-warning disabled">
		<input type="button" value="Devolver Vehículo" onclick="window.location.href='devolver_controller.php'" class="btn btn-warning disabled">
		</br></br>
		
		
		
		<a href="movwelcome.php?accion=eliminar">Cerrar Sesión</a>
	</div>  
	</form>
   </body>
   
</html>


