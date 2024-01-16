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
	$dbname = "COMPRASWEB";
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $conn;
}

function iniciada(){
	$cookie_name = "usuario";
	if(!isset($_COOKIE[$cookie_name])) {
		header("Location: comlogincli.html");
		exit();
	}
}

function consulta_almacen($conn,$nif,$fechaIni,$fechaFin){
	$array = array();
	$gastos = array();
	$gasto = 0;
	$stmt = $conn->prepare("SELECT * FROM COMPRA WHERE NIF = :nif AND FECHA_COMPRA >= :fechaIni AND FECHA_COMPRA <= :fechaFin");
	$stmt->bindParam(':nif',$nif);
	$stmt->bindParam(':fechaIni',$fechaIni);
	$stmt->bindParam(':fechaFin',$fechaFin);
	$stmt->execute();
	
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$resultado=$stmt->fetchAll();
	
	foreach($resultado as $row) {
		$stmt = $conn->prepare("SELECT * FROM PRODUCTO WHERE ID_PRODUCTO = :id_producto");
		$stmt->bindParam(':id_producto',$row['ID_PRODUCTO']);
		$stmt->execute();
		
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$resultado2=$stmt->fetchAll();
		foreach($resultado2 as $row2) {
			$array[] = [$row['FECHA_COMPRA'],$row2['NOMBRE'],$row2['PRECIO'],$row['UNIDADES']];
			$gasto += $row2['PRECIO'] * $row['UNIDADES'];
		}
	}
	$gastos[] = $gasto;
	return [$array,$gastos];
}

function mostrar_pantalla($array,$nif){
	if(empty($array[0])){
		echo "No has hecho ninguna compra en ese rango de fecha.";
	}else{
		echo "Tus compras:<br/>";
		$tabla = "<table><tr><td>FECHA</td><td>NOMBRE</td><td>PRECIO</td><td>CANTIDAD</td></tr>";
		for($i = 0; $i < count($array[0]); $i++){
			$tabla .= "<tr>";
			for($x = 0; $x < count($array[0][$i]); $x++){
				if($x == 2){
					$precio = $array[0][$i][2] * $array[0][$i][3];
					$tabla .= "<td>".$precio."€</td>";
				}else if($x == 3){
					if($array[0][$i][$x] > 1){
						$tabla .= "<td>".$array[0][$i][$x]." unidades</td>";
					}else{
						$tabla .= "<td>".$array[0][$i][$x]." unidad</td>";
					}
				}else{
					$tabla .= "<td>".$array[0][$i][$x]."</td>";
				}
			}
			$tabla .= "</tr>";
		}
		$tabla .= "<td>GASTOS TOTALES</td><td>".$array[1][0]."€</td>";
		$tabla .= "</table>";
		echo $tabla;
	}
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

function add_cesta_session($conn,$producto,$cantidad){
	$stmt = $conn->prepare("SELECT PRECIO FROM PRODUCTO WHERE ID_PRODUCTO = :id_producto LIMIT 1");
	$stmt->bindParam(':id_producto',$producto);
	$stmt->execute();
	
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$resultado2=$stmt->fetchAll();
	if (!isset($_SESSION['array'])) {
        $_SESSION['array'] = array();
    }
    foreach($resultado2 as $row2) {
		$precio = $row2['PRECIO'] * $cantidad;
		$_SESSION['array'][$producto] = [$cantidad,$precio];
	}
	$array = $_SESSION['array'];
	return $array;
}

function add_cesta_cookie($conn,$producto,$cantidad,$cookie_name){
	$cookie_content = isset($_COOKIE[$cookie_name]) ? $_COOKIE[$cookie_name] : null;
    $array2 = $cookie_content ? unserialize($cookie_content) : array();
	
	$stmt = $conn->prepare("SELECT PRECIO FROM PRODUCTO WHERE ID_PRODUCTO = :id_producto LIMIT 1");
	$stmt->bindParam(':id_producto',$producto);
	$stmt->execute();
	
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$resultado2=$stmt->fetchAll();
	if(!isset($array2)){
		$array2 = array();
	}
    foreach($resultado2 as $row2) {
		$precio = $row2['PRECIO'] * $cantidad;
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

function insert_compra($conn,$nif,$array){
	foreach($array as $idproducto => $elemento){
		$stmt = $conn->prepare("SELECT * FROM ALMACENA WHERE ID_PRODUCTO = :producto && CANTIDAD >= :cantidad LIMIT 1");
		$stmt->bindParam(':producto', $idproducto);
		$stmt->bindParam(':cantidad', $elemento[0]);
		$stmt->execute();
		
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$resultado3=$stmt->fetchAll();
		if(!empty($resultado3)){
			$stmt = $conn->prepare("INSERT INTO COMPRA (NIF,ID_PRODUCTO,FECHA_COMPRA,UNIDADES) VALUES (:nif,:id,CURRENT_DATE,:cantidad)");
			$stmt->bindParam(':nif', $nif);
			$stmt->bindParam(':id', $idproducto);
			$stmt->bindParam(':cantidad', $elemento[0]);
			$stmt->execute();
			foreach($resultado3 as $row){
				$stmt = $conn->prepare("UPDATE ALMACENA SET CANTIDAD = CANTIDAD - :cantidad WHERE ID_PRODUCTO = :id AND NUM_ALMACEN = :almacen");
				$stmt->bindParam(':id', $idproducto);
				$stmt->bindParam(':cantidad', $elemento[0]);
				$stmt->bindParam(':almacen', $row['NUM_ALMACEN']);
				$stmt->execute();
			}
			echo "Se han actualizado los almacenes </br>";
		}else{
			throw new Exception("No hay suficientes productos de ".$idproducto);
			//unset($_SESSION['array'][$idproducto]);
		}
	}
	setcookie('array','',-1,'/');
	//unset($_SESSION['array']);
}

function cargar_producto($conn){
	$stmt = $conn->prepare("SELECT ID_PRODUCTO, NOMBRE FROM PRODUCTO");
	$stmt->execute();
	
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$resultado=$stmt->fetchAll();
	foreach($resultado as $row) {
		$array[$row['ID_PRODUCTO']] = $row['NOMBRE'];
	}
	return $array;
}

function comprobar_cliente($conn,$username,$password,$nif){
	$stmt = $conn->prepare("SELECT NOMBRE, APELLIDO FROM CLIENTE WHERE NOMBRE = :username AND APELLIDO = :password AND NIF = :nif");
	$stmt->bindParam(':username', $username);
	$stmt->bindParam(':password', strrev($password));
	$stmt->bindParam(':nif',$nif);
    $stmt->execute();
	
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$resultado=$stmt->fetchAll();
	
	if(!empty($resultado)){
		setcookie("usuario",strtolower($username),time() + 3600,"/");
		//setcookie("clave",strrev(strtolower($password)),time() + 3600,"/");
		setcookie("nif",$nif,time() + 3600,"/");
		header("Location: login_home.php");
		exit();
	}else{
		throw new Exception("Las credenciales son incorrectas");
	}
}

function insert_cliente($conn,$nif,$nombre,$apellido,$cp,$direccion,$ciudad){
	$stmt = $conn->prepare("SELECT NIF FROM CLIENTE WHERE NIF = :nif");
	$stmt->bindParam(':nif', $nif);
    $stmt->execute();
	
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$resultado=$stmt->fetchAll();
	
	if(empty($resultado)){
		if(strlen($nif) === 9){
			$numeros = substr($nif,0,-1);
			$letra = substr($nif,-1);
			if(is_numeric($numeros) && is_string($letra)){
				$stmt = $conn->prepare("INSERT INTO CLIENTE (NIF,NOMBRE,APELLIDO,CP,DIRECCION,CIUDAD) VALUES (:nif,:nombre,:apellido,:cp,:direccion,:ciudad)");
				$stmt->bindParam(':nif', $nif);
				$stmt->bindParam(':nombre', $nombre);
				$stmt->bindParam(':apellido', $apellido);
				$stmt->bindParam(':cp', $cp);
				$stmt->bindParam(':direccion', $direccion);
				$stmt->bindParam(':ciudad', $ciudad);
				$stmt->execute();
				echo "New records created successfully";
			}else{
				throw new Exception("El nif que has introducido no es un nif");
			}
		}else if($nif == ""){
			throw new Exception("El campo nif esta vacio");
		}else if(strlen($nif) < 9){
			throw new Exception("El campo nif no cumple con el tamaño establecido");
		}
	}else{
		throw new Exception("Ya hay un cliente con ese nif");
	}
	
}
?>