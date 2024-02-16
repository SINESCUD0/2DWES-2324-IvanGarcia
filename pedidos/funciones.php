<?php
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function conexion(){
	$servername = "localhost";
	$username = "root";
	$password = "rootroot";
	$dbname = "pedidos";
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $conn;
}

function iniciada(){
	$cookie_name = "usuario";
	if(!isset($_COOKIE[$cookie_name])) {
		header("Location: pe_login.php");
		exit();
	}
}

function comprobar_cliente($conn,$username,$password){
	$stmt = $conn->prepare("SELECT * FROM CUSTOMERS WHERE CUSTOMERNUMBER = :username AND CONTACTLASTNAME = :password");
	$stmt->bindParam(':username', $username);
	$stmt->bindParam(':password', $password);
    $stmt->execute();
	
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$resultado=$stmt->fetchAll();
	
	if(!empty($resultado)){
		setcookie("usuario",$username,time() + 3600,"/");
		//echo "Usuario Correcto";
		header("Location: pe_inicio.php");
		exit();
	}else{
		throw new Exception("Las credenciales son incorrectas");
	}
}

function add_cesta_cookie($conn,$producto,$cantidad,$cookie_name){
	$cookie_content = isset($_COOKIE[$cookie_name]) ? $_COOKIE[$cookie_name] : null;
    $array2 = $cookie_content ? unserialize($cookie_content) : array();
	
	$stmt = $conn->prepare("SELECT BUYPRICE FROM PRODUCTS WHERE productCode = :id_producto LIMIT 1");
	$stmt->bindParam(':id_producto',$producto);
	$stmt->execute();
	
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$resultado2=$stmt->fetchAll();
	if(!isset($array2)){
		$array2 = array();
	}
    foreach($resultado2 as $row2) {
		$precio = $row2['BUYPRICE'] * $cantidad;
		if(isset($array2[$producto])){
			$array2[$producto][0] += $cantidad;
            $array2[$producto][1] += $precio;
		}else {
            $array2[$producto] = array($cantidad, $precio);
        }
	}
	$serializado = serialize($array2);
	setcookie($cookie_name,$serializado,time() + 3600,"/");
	return $array2;
}

function mostrar_cesta($conn,$array){
	$array2 = cargar_producto($conn);
	$precio = 0;
	$tabla = "<table><tr><td>Producto</td><td>Cantidad</td><td>Coste</td></tr>";
	foreach($array as $idproducto => $elemento){
		foreach($array2 as $id => $nombre){
			if($id == $idproducto){
				$tabla .= "<tr><td>$nombre</td><td>".$elemento[0]."</td><td>".$elemento[1]."€</td></tr>";
				$precio += $elemento[1];
			}
		}
	}
	$tabla .= "<tr><td>Precio Total</td><td>".$precio."€</td></tr></table>";
	return $tabla;
}

function select_compra($conn,$array){
	$precioTotal = 0;
	foreach($array as $idproducto => $elemento){
		$precioTotal += $elemento[1];
	}
	$stmt = $conn->prepare("SELECT MAX(OrderNumber) AS NUMERO FROM ORDERS LIMIT 1");
	$stmt->execute();
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$numeroOrden=$stmt->fetchAll();
	$order = 0;
	foreach($numeroOrden as $row1){
		$order = $row1['NUMERO'] + 2;
	}
	$total = str_replace('.','',$precioTotal);
	$amount = $precioTotal * 100;
	$variable = 'true';
	$array = array($amount,$order,$variable);
	return $array;
}

function insert_compra($conn,$usuario,$checkNumber,$array){
	$precioTotal = 0;
	foreach($array as $idproducto => $elemento){
		$precioTotal += $elemento[1];
	}
	//SELECCIONO EL VALOR DE LA ORDEN MAS ALTA PARA PODER DARLE UN NUEVO NUMERO A LA SIGUIENTE ORDEN
	$selectOrderNumber = $conn->prepare("SELECT MAX(OrderNumber) AS NUMERO FROM ORDERS LIMIT 1");
	$selectOrderNumber->execute();
	$selectOrderNumber->setFetchMode(PDO::FETCH_ASSOC);
	$numeroOrden=$selectOrderNumber->fetchAll();
	$order = 0;
	foreach($numeroOrden as $row1){
		$order = $row1['NUMERO'] + 1;
		
		//INSERTAMOS LOS VALORES DE LA NUEVA ORDEN QUE SE HA CREADO
		$insertOrders = $conn->prepare("INSERT INTO ORDERS (orderNumber,orderDate,requiredDate,shippedDate,customerNumber,status) VALUES (:order,CURRENT_DATE,CURRENT_DATE,NULL,:user,'In Process')");
		$insertOrders->bindParam(':user', $usuario);
		$insertOrders->bindParam(':order', $order);
		
		//INSERTAMOS LOS VALORES DEL NUEVO PAYMENTS
		$insertPayments = $conn->prepare("INSERT INTO PAYMENTS (customerNumber,checkNumber,paymentDate,amount) VALUES (:user,:number,CURRENT_DATE,:precio)");
		$insertPayments->bindParam(':user', $usuario);
		$insertPayments->bindParam(':number', $checkNumber);
		$insertPayments->bindParam(':precio', $precioTotal);
		
		//HAGO UN TRY CATCH PARA EJECUTAR LOS DOS INSERTS
		try{
			$conn->beginTransaction();
			$insertOrders->execute();
			$insertPayments->execute();
			$conn->commit();
		}catch(Exception $e){
			$conn->rollback();
			throw $e;
			break;
		}
	}
	foreach($array as $idproducto => $elemento){
		//SELECCIONO EL PRODUCTO QUE VA A COMPRAR EL CLIENTE
		$selectProducts = $conn->prepare("SELECT * FROM PRODUCTS WHERE productCode = :producto && quantityInStock >= :cantidad LIMIT 1");
		$selectProducts->bindParam(':producto', $idproducto);
		$selectProducts->bindParam(':cantidad', $elemento[0]);
		$selectProducts->execute();
		
		$selectProducts->setFetchMode(PDO::FETCH_ASSOC);
		$resultado3=$selectProducts->fetchAll();
		if(!empty($resultado3)){
			foreach($resultado3 as $row){
				$numeroAleatorio = rand(1,15);
				
				//INSERTAMOS LOS VALORES NUEVOS DENTRO DE LA TABLA ORDERDETAILS
				$insertOrderdetails = $conn->prepare("INSERT INTO ORDERDETAILS (orderNumber,productCode,quantityOrdered,orderLineNumber,priceEach) VALUES (:order,:id,:cantidad,:prioridad,:precio)");
				$insertOrderdetails->bindParam(':id', $idproducto);
				$insertOrderdetails->bindParam(':cantidad', $elemento[0]);
				$insertOrderdetails->bindParam(':order', $order);
				$insertOrderdetails->bindParam(':prioridad', $numeroAleatorio);
				$insertOrderdetails->bindParam(':precio', $row['buyPrice']);
				
				//ACTUALIZO LA LISTA DE PRODUCTOS CON LA NUEVA CANTIDAD
				$updateProducts = $conn->prepare("UPDATE PRODUCTS SET quantityInStock = quantityInStock - :cantidad WHERE productCode = :id");
				$updateProducts->bindParam(':cantidad', $elemento[0]);
				$updateProducts->bindParam(':id', $idproducto);
				
				//HAGO EL TRY CATCH PARA EJECUTAR EL INSERT Y EL UPDATE DE LAS TABLAS ORDERDETAILS Y PRODUCTS
				try{
					$conn->beginTransaction();
					$insertOrderdetails->execute();
					$updateProducts->execute();
					$conn->commit();
				}catch(Exception $e){
					$conn->rollback();
					throw $e;
					break;
				}
			}
		}else{
			throw new Exception("No hay suficientes productos de ".$idproducto);
			break;
		}
	}
}

function pasarela($amount,$order){
	// Se incluye la librería
	include 'apiRedsys.php';
	$urlOK = "http://10.2.102.4/pedidos/pe_altaped.php";
	$urlKO = "http://10.2.102.4/pedidos/pe_altaped.php";
	// Se crea Objeto
	$miObj = new RedsysAPI;
	$miObj->setParameter("DS_MERCHANT_AMOUNT", $amount);
	$miObj->setParameter("DS_MERCHANT_ORDER", $order);
	$miObj->setParameter("DS_MERCHANT_MERCHANTCODE", 999008881);
	//$miObj->setParameter("DS_MERCHANT_MERCHANTDATA",$conn);
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
	
	return [$version,$params,$signature];
}

function numero_cliente($conn){
	$stmt = $conn->prepare("SELECT customerNumber FROM CUSTOMERS");
	$stmt->execute();
	
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$resultado=$stmt->fetchAll();
	foreach($resultado as $row) {
		$array[] = $row['customerNumber'];
	}
	return $array;
}

function pedidos($conn,$user){
	$array = array();
	$stmt = $conn->prepare("SELECT orderNumber,orderDate,status FROM ORDERS WHERE customerNumber = :user");
	$stmt->bindParam(':user', $user);
	$stmt->execute();
	
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$resultado=$stmt->fetchAll();
	foreach($resultado as $row){
		$order = $row['orderNumber'];
		$stmt = $conn->prepare("SELECT orderLineNumber,productCode,quantityOrdered,priceEach FROM ORDERDETAILS WHERE orderNumber = :order");
		$stmt->bindParam(':order', $order);
		$stmt->execute();
		
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$resultado2=$stmt->fetchAll();
		foreach($resultado2 as $row2){
			$producto = $row2['productCode'];
			$stmt = $conn->prepare("SELECT productName FROM PRODUCTS WHERE productCode = :producto");
			$stmt->bindParam(':producto', $producto);
			$stmt->execute();
			
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			$resultado3=$stmt->fetchAll();
			foreach($resultado3 as $row3){
				$array[$row['orderNumber']][$row3['productName']] = array($row['orderDate'],$row['status'],$row2['orderLineNumber'],$row2['quantityOrdered'],$row2['priceEach']); 
			}
		}
	}
	return $array;
}

function mostrar_pedidos($array, $cliente){
	if(!empty($array)){
		$tabla = "<label>Cliente Numero: $cliente</label><br/><table><tr><td>Numero Pedido</td><td>Fecha Pedido</td><td>Estado Pedido</td><td>Numero de Linea</td><td>Nombre Producto</td><td>Cantidad Pedida</td><td>Precio Unidad</td></tr>";
		foreach ($array as $orderNumber => $orderDetails) {
			foreach ($orderDetails as $productName => $productDetails) {
				$orderDate = $productDetails[0];
				$status = $productDetails[1];
				$orderLineNumber = $productDetails[2];
				$quantityOrdered = $productDetails[3];
				$precio = $productDetails[4];
				$tabla .= "<tr><td>$orderNumber</td><td>$orderDate</td><td>$status</td><td>$orderLineNumber</td><td>$productName</td><td>$quantityOrdered</td><td>$precio €</td></tr>";
			}
		}
		$tabla .= "</table>";
	}else{
		$tabla = "No hay ningun pedido de este cliente";
	}
	return $tabla;
}

function stock($conn,$producto){
	$array = array();
	$stmt = $conn->prepare("SELECT * FROM PRODUCTS WHERE productCode = :producto AND quantityInStock > 0");
	$stmt->bindParam(':producto', $producto);
	$stmt->execute();
	
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$resultado=$stmt->fetchAll();
	foreach($resultado as $row){
		$array[$row['productCode']] = array($row['productName'],$row['quantityInStock']);
	}
	return $array;
}

function linea_stock($conn,$linea){
	$array = array();
	$stmt = $conn->prepare("SELECT * FROM PRODUCTS WHERE productLine = :linea AND quantityInStock > 0 ORDER BY quantityInStock DESC");
	$stmt->bindParam(':linea', $linea);
	$stmt->execute();
	
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$resultado=$stmt->fetchAll();
	foreach($resultado as $row){
		$array[$row['productCode']] = array($row['productName'],$row['quantityInStock']);
	}
	return $array;
}

function pedidos_fechas($conn,$fecha1, $fecha2){
	$array = array();
	$stmt = $conn->prepare("SELECT * FROM ORDERS WHERE orderDate >= :fecha1 AND orderDate <= :fecha2");
	$stmt->bindParam(':fecha1', $fecha1);
	$stmt->bindParam(':fecha2', $fecha2);
	$stmt->execute();
	
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$resultado=$stmt->fetchAll();
	foreach($resultado as $row){
		$stmt = $conn->prepare("SELECT productCode, SUM(quantityOrdered) AS cantidad FROM ORDERDETAILS WHERE orderNumber = :order GROUP BY productCode");
		$stmt->bindParam(':order', $row['orderNumber']);
		$stmt->execute();
		
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$resultado2=$stmt->fetchAll();
		foreach($resultado2 as $row2){
			$array[$row2['productCode']] = array($row2['cantidad']);
		}
	}
	return $array;
}

function pagos_fechas($conn,$fecha1, $fecha2,$cliente){
	$array = array();
	if($fecha1 != '' && $fecha2 != ''){
		$stmt = $conn->prepare("SELECT * FROM PAYMENTS WHERE paymentDate >= :fecha1 AND paymentDate <= :fecha2 AND customerNumber = :cliente");
		$stmt->bindParam(':fecha1', $fecha1);
		$stmt->bindParam(':fecha2', $fecha2);
		$stmt->bindParam(':cliente',$cliente);
		$stmt->execute();
		
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$resultado=$stmt->fetchAll();
		foreach($resultado as $row){
			$array[$row['paymentDate']] = array($row['checkNumber'],$row['amount']);
		}
	}elseif($fecha1 == '' && $fecha2 != ''){
		$stmt = $conn->prepare("SELECT * FROM PAYMENTS WHERE paymentDate <= :fecha2 AND customerNumber = :cliente");
		$stmt->bindParam(':fecha2', $fecha2);
		$stmt->bindParam(':cliente',$cliente);
		$stmt->execute();
		
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$resultado=$stmt->fetchAll();
		foreach($resultado as $row){
			$array[$row['paymentDate']] = array($row['checkNumber'],$row['amount']);
		}
	}elseif($fecha1 != '' && $fecha2 == ''){
		$stmt = $conn->prepare("SELECT * FROM PAYMENTS WHERE paymentDate >= :fecha1 AND customerNumber = :cliente");
		$stmt->bindParam(':fecha1', $fecha1);
		$stmt->bindParam(':cliente',$cliente);
		$stmt->execute();
		
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$resultado=$stmt->fetchAll();
		foreach($resultado as $row){
			$array[$row['paymentDate']] = array($row['checkNumber'],$row['amount']);
		}
	}else{
		$stmt = $conn->prepare("SELECT * FROM PAYMENTS WHERE customerNumber = :cliente");
		$stmt->bindParam(':cliente',$cliente);
		$stmt->execute();
		
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$resultado=$stmt->fetchAll();
		foreach($resultado as $row){
			$array[$row['paymentDate']] = array($row['checkNumber'],$row['amount']);
		}
	}
	
	return $array;
}

function mostrar_stock($array){
	if(!empty($array)){
		$tabla = "<table><tr><td>Numero Producto</td><td>Nombre Producto</td><td>Stock</td></tr>";
		foreach ($array as $productCode => $elementos) {
			$tabla .= "<tr><td>$productCode</td><td>".$elementos[0]."</td><td>".$elementos[1]."</td></tr>";
		}
		$tabla .= "</table>";
	}else{
		$tabla = "No hay stock";
	}
	return $tabla;
}

function mostrar_pedidos_fecha($array){
	if(!empty($array)){
		$tabla = "<table><tr><td>Numero Producto</td><td>Cantidad Ordenada</td></tr>";
		foreach ($array as $productCode => $elementos) {
			$tabla .= "<tr><td>$productCode</td><td>".$elementos[0]."</td></tr>";
		}
		$tabla .= "</table>";
	}else{
		$tabla = "No hubo ningun pedido";
	}
	return $tabla;
}

function mostrar_pagos_fecha($array){
	if(!empty($array)){
		$tabla = "<table><tr><td>Fecha Pago</td><td>Check Number</td><td>Amount</td></tr>";
		foreach ($array as $paymentDate => $elementos) {
			$tabla .= "<tr><td>$paymentDate</td><td>".$elementos[0]."</td><td>".$elementos[1]."</td></tr>";
		}
		$tabla .= "</table>";
	}else{
		$tabla = "No hubo ningun pedido";
	}
	return $tabla;
}

function cargar_producto($conn){
	$stmt = $conn->prepare("SELECT productCode,ProductName FROM PRODUCTS WHERE QUANTITYINSTOCK > 0");
	$stmt->execute();
	
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$resultado=$stmt->fetchAll();
	foreach($resultado as $row) {
		$array[$row['productCode']] = $row['ProductName'];
	}
	return $array;
}

function cargar_producto_stock($conn){
	$stmt = $conn->prepare("SELECT * FROM PRODUCTS");
	$stmt->execute();
	
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$resultado=$stmt->fetchAll();
	foreach($resultado as $row) {
		$array[$row['productCode']] = $row['productName'];
	}
	return $array;
}

function cargar_producto_stock_linea($conn){
	$stmt = $conn->prepare("SELECT DISTINCT productLine FROM PRODUCTS");
	$stmt->execute();
	
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$resultado=$stmt->fetchAll();
	foreach($resultado as $row) {
		$array[] = $row['productLine'];
	}
	return $array;
}

function mostrar_selects($array){
	foreach ($array as $id => $nombre) {
    	echo "<option value=\"$id\">$nombre</option>";
    }
}

function mostrar_selects2($array){
	foreach ($array as $nombre) {
    	echo "<option value=\"$nombre\">$nombre</option>";
    }
}
?>