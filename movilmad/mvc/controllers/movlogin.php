<?php
require_once $_SERVER['DOCUMENT_ROOT']."/movilmad/mvc/models/login_models.php";
if(isset($_COOKIE['login'])){
	header('location:http://192.168.206.222/movilmad/mvc/controllers/movwelcome.php');
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$_username = trim($_POST['email']);
	$_password = trim($_POST['password']);

	$_resultado = obtenerCliente($_username,$_password);
	if($_resultado){
		setcookie("login",$_username,time() + 3600,"/");
		header('location:http://192.168.206.222/movilmad/mvc/controllers/movwelcome.php');
		exit();
	}else{
		header('location:http://192.168.206.222/movilmad/mvc/controllers/movlogin.php?msg=No coinciden las credenciales	');
		exit();
	}
}
?>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Login Page - MovilMad</title>
		<link rel="stylesheet" href="http://192.168.206.222/movilmad/mvc/public/css/bootstrap.min.css">
	</head>
	<style>
		#mensajeError{
			color:red;
		}
	</style>
      
<body>
    <h1>MOVILMAD</h1>

    <div class="container ">
        <!--Aplicacion-->
		<div class="card border-success mb-3" style="max-width: 30rem;">
			<div class="card-header">Login Usuario</div>
			<div class="card-body">
				<form id="" name="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="card-body">
					<div class="form-group">
						Email <input type="text" name="email" placeholder="email" class="form-control">
					</div>
					<div class="form-group">
						Clave <input type="password" name="password" placeholder="password" class="form-control">
					</div>				
					
					<input type="submit" name="submit" value="Login" class="btn btn-warning disabled">
				</form>
				<p id="mensajeError"><?php echo ((isset($_GET['msg']))) ? $_GET['msg'] : "" ?></p>
			</div>
		</div>
	</div>
</body>
</html>