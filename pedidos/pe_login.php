<?php
include('funciones.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera los datos del formulario
    $username = test_input($_POST["username"]);
    $password = test_input($_POST["password"]);
	
	try{
		$conn = conexion();
		comprobar_cliente($conn,$username,$password);
	}catch(Exception $a){
		echo $a->getMessage();
	}
	$conn = null;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
</head>
<body>
    <h2>Iniciar sesión</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <label for="username">Usuario:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="Iniciar sesión">
    </form>
</body>
</html>
