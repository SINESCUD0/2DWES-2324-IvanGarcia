<?php
include('funciones.php');
iniciada();
$tabla = "";
$PEDIDOS = array();
$version = '';
$params = '';
$signature = '';
$amount = '';
$order = '';
$array = array();
$enviar = array();
$insertar_compra = array();
$variable = '';
$errorForm = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if(isset($_POST['end'])){
		if(!empty($_COOKIE['array'])){
			$errorForm = '';
			$array = unserialize($_COOKIE['array']);
			try{
				$conn = conexion();
				$PEDIDOS = select_compra($conn,$array);
				if (!empty($PEDIDOS)) {
					$amount = $PEDIDOS[0];
					$order = $PEDIDOS[1];
					$variable = $PEDIDOS[2];
					$enviar = pasarela($amount,$order);
				}
			}catch(PDOException $e){
				echo "Error: " . $e->getMessage();
			}catch(Exception $a){
				echo $a->getMessage();
			}
			$version = $enviar[0];
			$params = $enviar[1];
			$signature = $enviar[2];
		}else{
			$errorForm = "No hay carrito de la compra";
		}
    }
	if(isset($_POST['boton'])){
		$user = test_input($_COOKIE['usuario']);
		$checkNumber = test_input($_POST['checkNumber']);
		$array = unserialize($_COOKIE['array']);
		$insertar_compra = array($user,$checkNumber,$array);
		$serializado = serialize($insertar_compra);
		setcookie("insertar",$serializado,time() + 3600,"/");
	}
    if(isset($_POST['add'])){
        $cookie_name = "array";
		$errorForm = '';
        $conn = conexion();
        $producto = test_input($_POST['producto']);
        $cantidad = test_input($_POST['cantidad']);
        $array = add_cesta_cookie($conn,$producto,$cantidad,$cookie_name);
        $tabla = mostrar_cesta($conn,$array);
    }
}
if(!empty($_GET)){
	include 'apiRedsys.php';
	// Se crea Objeto
	$miObj = new RedsysAPI;
	$version = $_GET['Ds_SignatureVersion'];
	$params = $_GET['Ds_MerchantParameters'];
	$signature = $_GET['Ds_Signature'];
	
	$decodec = $miObj->decodeMerchantParameters($params);
	
	$codigoRespuesta = $miObj->getParameter("Ds_Response");
	$kc = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7'; //Clave recuperada de CANALES
	$firma = $miObj->createMerchantSignatureNotif($kc,$params);
	
	if($codigoRespuesta >= 0 && $codigoRespuesta <= 99){
		echo "OPERACION EXITOSA <br/>";
		$insertar_compra = unserialize($_COOKIE['insertar']);
		try{
			$conn = conexion();
			insert_compra($conn,$insertar_compra[0],$insertar_compra[1],$insertar_compra[2]);
		}catch(Exception $e){
			echo "Error: " . $e->getMessage();
		}
		setcookie('array','',-1,'/');
		setcookie('insertar','',-1,'/');
		if($firma === $signature){
			echo "ERES LA MISMA PERSONA";
		}else{
			echo "NO ERES LA MISMA PERSONA";
		}
	}else{
		echo "OPERACION NO EXITOSA";
	}
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Pedidos</title>
	<script type="text/javascript">
		window.onload =cargado;
		function cargado(){
			document.formulario.checkNumber.onkeypress=checkNumber;
			mostrarDialogo();
			document.formulario.boton.onclick = cerrarDialogo;
		}
		function checkNumber(evento){
			var valido=true;
			var valor=String.fromCharCode(evento.charCode).toUpperCase();
			if ((valor >= 'A' && valor <= 'Z' && evento.target.value.length < 2) || (valor >= '0' && valor <= '9' && evento.target.value.length >= 2 && evento.target.value.length < 7)) {
				valido=true;
			}else{
				valido=false;
			}
			return valido;
		}
		function mostrarDialogo() {
			var mostrar = <?php echo json_encode($variable); ?>;
			if(mostrar === 'true'){
				document.getElementById('miDialogo').showModal();
			}
		}
		function cerrarDialogo() {
			var number = document.formulario.checkNumber.value;
			if(number.length == 7){
				var mensajeError = document.getElementById('mensajeError');
				mensajeError.textContent = '';
				document.frm.submit();
				return true;
			}else{
				var mensajeError = document.getElementById('mensajeError');
				mensajeError.textContent = '*La entrada debe tener 7 caracteres';
				mensajeError.style.color = "red";
				return false;
			}
		}
	</script>
	<STYLE>
		td, tr{
			text-align: center; 
			border: 1px solid; 
			width: 150px;
		}
		#errorForm{
			color:red;
			font-size:30px;
		}
	</STYLE>
</head>
<body>
    <h2>Pedidos</h2>
    <form name="formulario" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <label for="producto">Producto:</label>
		<select name="producto">
		<?php
			try {
				$conn = conexion();
				$array2 = array();
				$array2 = cargar_producto($conn);
				mostrar_selects($array2);
			}catch(PDOException $e){
				echo "Error: " . $e->getMessage();
			}
			$conn = null;
		?>
		</select>
		<br/><br/>
		<label for="cantidad">Cantidad:</label>
		<input type="number" name="cantidad"/>
		<br/><br/>
        <input type="submit" name="add" id="submit1" value="Add Cesta" />
		<input type="submit" name="end" id="submit2" value="Finalizar Pedido" />
		<a href="pe_inicio.php"><input type="button" value="Atras" /></a>
		<br/><br/>
		<p id="errorForm"><?php echo $errorForm;?></p>
		<?php
			if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])){
				echo $tabla;
			}
		?>
		<dialog id="miDialogo" disabled>
			<label>Check Number:</label>
			<input type='text' name='checkNumber' /><br/>
			<p id="mensajeError"></p>
		<input type="submit" name="boton" value="Realizar Pago"/>
	</dialog>
    </form>
	<form name="frm" action="https://sis-t.redsys.es:25443/sis/realizarPago" method="POST" target="_blank">
		<input type='hidden' name='Ds_SignatureVersion' value="<?php echo $version ?>">
		<input type='hidden' name='Ds_MerchantParameters' value="<?php echo $params ?>">
		<input type='hidden' name='Ds_Signature' value="<?php echo $signature ?>">
	</form>
</body>
</html>
