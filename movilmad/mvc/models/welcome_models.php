<?php
require_once $_SERVER['DOCUMENT_ROOT']."/movilmad/mvc/db/db.php";
function obtenerInformacion($username){
	global $conexion;
	$nombre;
	$apellido;
	$id;
	try {
		$obtenerInfo = $conexion->prepare("SELECT NOMBRE,APELLIDO,IDCLIENTE FROM RCLIENTES WHERE email = :user;");
		$obtenerInfo->bindParam(':user', $username);
		$obtenerInfo->execute();
		$informacion=$obtenerInfo->fetchAll();
		foreach($informacion as $row){
			$nombre = $row[0];
			$apellido = $row[1];
			$id = $row[2];
		}
		return [$nombre,$apellido,$id];
	} catch (PDOException $ex) {
		echo $ex->getMessage();
		return false;
	}
}

function alquilarCoches($array,$fecha,$id){
	global $conexion;
	$numero = 0;
	try {
		$conexion->beginTransaction();
		foreach($array as $matricula => $elemento){
			$obtenerInfo = $conexion->prepare("SELECT COUNT(*) AS NUMERO FROM RALQUILERES WHERE IDCLIENTE = :id AND fechahorapago = NULL;");
			$obtenerInfo->bindParam(":id",$id);
			$obtenerInfo->execute();
			$informacion=$obtenerInfo->fetchAll();
			foreach($informacion as $row){
				$numero = $row['NUMERO'];
			}
			if($numero < 3){
				$alquiler = $conexion->prepare("INSERT INTO RALQUILERES (idcliente,matricula,fecha_alquiler) VALUES(:id,:matricula,:fecha);");
				$alquiler->bindParam(":id",$id);
				$alquiler->bindParam(":matricula",$matricula);
				$alquiler->bindParam(":fecha",$fecha);
				$alquiler->execute();
				$coche = $conexion->prepare("UPDATE RVEHICULOS SET disponible = 'N' WHERE matricula = :matricula;");
				$coche->bindParam(":matricula",$matricula);
				$coche->execute();
			}else{
				echo "<p>No se han alquilado ningun coche ya que tienes coches pendientes de pago</p>";
				$conexion->rollBack();
			}
		}
		$conexion->commit();
	} catch (PDOException $ex) {
		echo $ex->getMessage();
	}
}

function obtenerCoches(){
	global $conexion;
	$numero = 0;
	try {
		$obtenerInfo = $conexion->prepare("SELECT COUNT(*) AS NUMERO FROM RVEHICULOS WHERE DISPONIBLE = 'S';");
		$obtenerInfo->execute();
		$informacion=$obtenerInfo->fetchAll();
		foreach($informacion as $row){
			$numero = $row['NUMERO'];
		}
		return $numero;
	} catch (PDOException $ex) {
		echo $ex->getMessage();
	}
}

function selectCoches(){
	global $conexion;
	$array = array();
	try {
		$obtenerInfo = $conexion->prepare("SELECT * FROM RVEHICULOS WHERE DISPONIBLE = 'S';");
		$obtenerInfo->execute();
		$informacion=$obtenerInfo->fetchAll();
		foreach($informacion as $row){
			$array[$row['matricula']] = array($row['marca'],$row['modelo']);
		}
		return $array;
	} catch (PDOException $ex) {
		echo $ex->getMessage();
	}
}

function selectCochesDevolver($id){
	global $conexion;
	$array = array();
	try {
		$obtenerInfo = $conexion->prepare("SELECT * FROM RALQUILERES WHERE fecha_devolucion IS NULL AND idcliente = :id;");
		$obtenerInfo->bindParam(":id",$id);
		$obtenerInfo->execute();
		$informacion=$obtenerInfo->fetchAll();
		foreach($informacion as $row){
			$obtenerInfo = $conexion->prepare("SELECT * FROM RVEHICULOS WHERE matricula = :matricula;");
			$obtenerInfo->bindParam(":matricula",$row['matricula']);
			$obtenerInfo->execute();
			$informacion2=$obtenerInfo->fetchAll();
			foreach($informacion2 as $row2){
				$array[$row2['matricula']] = array($row2['marca'],$row2['modelo']);
			}	
		}
		return $array;
	} catch (PDOException $ex) {
		echo $ex->getMessage();
	}
}

function devolverCoche($coche,$id,$fecha){
	global $conexion;
	try {
		$obtenerInfo = $conexion->prepare("SELECT * FROM RVEHICULOS WHERE matricula = :matricula;");
		$obtenerInfo->bindParam(":matricula",$coche);
		$obtenerInfo->execute();
		$informacion=$obtenerInfo->fetchAll();
		$obtenerInfo2 = $conexion->prepare("SELECT TIMESTAMPDIFF(MINUTE,fecha_alquiler,:fecha) AS MINUTOS FROM RALQUILERES WHERE matricula = :matricula AND idcliente = :id AND fecha_devolucion IS NULL;");
		$obtenerInfo2->bindParam(":matricula",$coche);
		$obtenerInfo2->bindParam(":id",$id);
		$obtenerInfo2->bindParam(":fecha",$fecha);
		$obtenerInfo2->execute();
		$informacion2=$obtenerInfo2->fetchAll();
		$minutos = 0;
		$precioBase = 0;
		$fechaAlquiler = '';
		$obtenerInfo3 = $conexion->prepare("SELECT * FROM RALQUILERES WHERE matricula = :matricula AND idcliente = :id AND fecha_devolucion IS NULL;");
		$obtenerInfo3->bindParam(":matricula",$coche);
		$obtenerInfo3->bindParam(":id",$id);
		$obtenerInfo3->execute();
		$informacion3=$obtenerInfo3->fetchAll();
		foreach($informacion2 as $row2){
			$minutos = $row2['MINUTOS'];
		}
		foreach($informacion as $row){
			$precioBase = $row['preciobase'];
		}
		foreach($informacion3 as $row3){
			$fechaAlquiler = $row3['fecha_alquiler'];
		}
		$conexion->beginTransaction();
		$precioTotal = $precioBase * $minutos;
		$actualizarAlquiler = $conexion->prepare("UPDATE RALQUILERES SET fecha_devolucion = :fecha , preciototal = :precioTotal WHERE idcliente = :id AND matricula = :matricula AND fechahorapago IS NULL;");
		$actualizarAlquiler->bindParam(":id",$id);
		$actualizarAlquiler->bindParam(":fecha",$fecha);
		$actualizarAlquiler->bindParam(":precioTotal",$precioTotal);
		$actualizarAlquiler->bindParam(":matricula",$coche);
		$actualizarAlquiler->execute();
		$actualizarCoche = $conexion->prepare("UPDATE RVEHICULOS SET disponible = 'S' WHERE matricula = :matricula;");
		$actualizarCoche->bindParam(":matricula",$coche);
		$actualizarCoche->execute();
		
		// Se incluye la librería
		include $_SERVER['DOCUMENT_ROOT'].'/movilmad/mvc/models/apiRedsys.php';
		$urlOK = "http://192.168.206.222/movilmad/mvc/controllers/devolver_controller.php";
		$urlKO = "http://192.168.206.222/movilmad/mvc/controllers/devolver_controller.php";
		// Se crea Objeto
		$miObj = new RedsysAPI;
		$precio = $precioTotal * 100;
		$orden = $id ." ".$fecha." ".$fechaAlquiler." ".$coche;
		$data = $coche.','.$id.','.$fechaAlquiler;
		$miObj->setParameter("DS_MERCHANT_AMOUNT", $precio);
		$miObj->setParameter("DS_MERCHANT_MERCHANTDATA", $data);
		$miObj->setParameter("DS_MERCHANT_ORDER", $orden);
		$miObj->setParameter("DS_MERCHANT_MERCHANTCODE", 999008881);
		$miObj->setParameter("DS_MERCHANT_CURRENCY", 978);
		$miObj->setParameter("DS_MERCHANT_TRANSACTIONTYPE", 0);
		$miObj->setParameter("DS_MERCHANT_TERMINAL", 1);
		$miObj->setParameter("DS_MERCHANT_URLOK",$urlOK);
		$miObj->setParameter("DS_MERCHANT_URLKO",$urlKO);

		//Datos de configuración
		$version="HMAC_SHA256_V1";
		$kc = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7';//Clave recuperada de CANALES
		// Se generan los parámetros de la petición
		$request = "";
		$params = $miObj->createMerchantParameters();
		$signature = $miObj->createMerchantSignature($kc);
		echo '<form id="myForm" name="frm" action="https://sis-t.redsys.es:25443/sis/realizarPago" method="post" target="_blank">
				<input type="hidden" name="Ds_SignatureVersion" value="'.$version.'">
				<input type="hidden" name="Ds_MerchantParameters" value="'.$params.'">
				<input type="hidden" name="Ds_Signature" value="'.$signature.'">
			</form>';
		$conexion->commit();
	} catch (PDOException $ex) {
		echo $ex->getMessage();
		$conexion->rollBack();
	}
}

function confirmarCompra($data){
	global $conexion;
	try {
		$decoded_string = urldecode($data);
		$array = explode(',',$decoded_string);
		$coche = $array[0];
		$id = $array[1];
		$fechaAlquiler = $array[2];
		$conexion->beginTransaction();
		$actualizarAlquiler = $conexion->prepare("UPDATE RALQUILERES SET fechahorapago = NOW() WHERE idcliente = :id AND matricula = :matricula AND fecha_alquiler = :fecha;");
		$actualizarAlquiler->bindParam(":id",$id);
		$actualizarAlquiler->bindParam(":matricula",$coche);
		$actualizarAlquiler->bindParam(":fecha",$fechaAlquiler);
		$actualizarAlquiler->execute();
		$conexion->commit();
	} catch (PDOException $ex) {
		echo $ex->getMessage();
		$conexion->rollBack();
	}
}

function cancelarCompra($data){
	global $conexion;
	try {
		$decoded_string = urldecode($data);
		$array = explode(',',$decoded_string);
		$coche = $array[0];
		$id = $array[1];
		$fechaAlquiler = $array[2];
		$conexion->beginTransaction();
		$obtenerInfo = $conexion->prepare("SELECT * FROM RALQUILERES WHERE matricula = :matricula AND idcliente = :id AND fecha_alquiler = :fecha;");
		$obtenerInfo->bindParam(":matricula",$coche);
		$obtenerInfo->bindParam(":id",$id);
		$obtenerInfo->bindParam(":fecha",$fechaAlquiler);
		$obtenerInfo->execute();
		$informacion=$obtenerInfo->fetchAll();
		$pendientePago = 0;
		foreach($informacion as $row){
			$pendientePago = $row['preciototal'];
		}
		$actualizarCliente = $conexion->prepare("UPDATE RCLIENTES SET pendiente_pago = :precio WHERE idcliente = :id;");
		$actualizarCliente->bindParam(":id",$id);
		$actualizarCliente->bindParam(":precio",$pendientePago);
		$actualizarCliente->execute();
		$conexion->commit();
	} catch (PDOException $ex) {
		echo $ex->getMessage();
		$conexion->rollBack();
	}
}

function addCesta($coche){
	global $conexion;
	$cookie_content = isset($_COOKIE['cesta']) ? $_COOKIE['cesta'] : null;
    $array = $cookie_content ? unserialize($cookie_content) : array();
	try{
		$obtenerInfo = $conexion->prepare("SELECT * FROM RVEHICULOS WHERE matricula = :matricula;");
		$obtenerInfo->bindParam(":matricula",$coche);
		$obtenerInfo->execute();
		$informacion=$obtenerInfo->fetchAll();
		foreach($informacion as $row){
			if(count($array) < 3){
				$array[$row['matricula']] = array($row['marca'],$row['modelo']);
			}else{
				echo "<p>No puedes alquilar mas coches</p>";
				$array = unserialize($_COOKIE['cesta']);
				return $array;
			}
		}
		$serializado = serialize($array);
		setcookie('cesta',$serializado,time() + 3600,"/");
		return $array;
	}catch(PDOException $ex) {
		echo $ex->getMessage();
	}
}

function datosAlquileres($desde,$hasta,$id){
	global $conexion;
	$array = array();
	try {
		$obtenerInfo = $conexion->prepare("SELECT * FROM RALQUILERES WHERE fecha_alquiler >= :desde AND DATE(fecha_alquiler) <= :hasta AND idcliente = :id ORDER BY fecha_alquiler ASC;");
		$obtenerInfo->bindParam(":desde",$desde);
		$obtenerInfo->bindParam(":hasta",$hasta);
		$obtenerInfo->bindParam(":id",$id);
		$obtenerInfo->execute();
		$informacion=$obtenerInfo->fetchAll();
		$numero = 0;
		foreach($informacion as $row){
			$obtenerInfo2 = $conexion->prepare("SELECT * FROM RVEHICULOS WHERE matricula = :matricula;");
			$obtenerInfo2->bindParam(":matricula",$row['matricula']);
			$obtenerInfo2->execute();
			$informacion2=$obtenerInfo2->fetchAll();
			foreach($informacion2 as $row2){
				$array[$numero] = array($row['matricula'],$row2['marca'],$row2['modelo'],$row['fecha_alquiler'],$row['fecha_devolucion'],$row['preciototal']);
				$numero += 1;
			}
		}
		return $array;
	} catch (PDOException $ex) {
		echo $ex->getMessage();
	}
}

function mostrarTablaConsulta($array){
	$tabla = "<table><tr><th>Matricula</th><th>Marca</th><th>Modelo</th><th>Fecha Alquiler</th><th>Fecha Devolucion</th><th>Precio total</th></tr>";
	foreach($array as $valores){
		$tabla .= "<tr><td>".$valores[0]."</td><td>".$valores[1]."</td><td>".$valores[2]."</td><td>".$valores[3]."</td><td>".$valores[4]."</td><td>".$valores[5]."€</td></tr>";
	}
	$tabla .= "</table>";
	echo $tabla;
}

function mostrarTabla($array){
	$tabla = "<table><tr><th>Matricula</th><th>Marca</th><th>Modelo</th></tr>";
	foreach($array as $matricula => $valores){
		$tabla .= "<tr><td>$matricula</td><td>".$valores[0]."</td><td>".$valores[1]."</td></tr>";
	}
	$tabla .= "</table>";
	echo $tabla;
}
?>