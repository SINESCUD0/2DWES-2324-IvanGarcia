<HTML>
<HEAD> <TITLE>Base Datos</TITLE>
<STYLE>
td, tr{
	text-align: center; 
	border: 1px solid; 
	width: 150px;
}
</STYLE>
</HEAD>
<BODY>
<h1>COMPRA PRODUCTOS</h1>
<form name='mi_formulario' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
Id Producto:
<select name="producto">
<?php
	$cookie_name = "usuario";
	if(!isset($_COOKIE[$cookie_name])) {
		header("Location: comlogincli.html");
		exit();
	}
	try {
		$conn = conexion();
		$array = array();
		$array = cargar_producto($conn);
		foreach ($array as $id => $nombre) {
			echo "<option value=\"$id\">$nombre</option>";
		}
	}catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
	$conn = null;
?>
</select>
</br></br>
Cantidad:
<input type="number" name="cantidad"/>
<br/><br/>
<input type="submit" value="Add Cesta" name="add"/>
<input type="submit" value="Finalizar Compra" name="end">
<a href="login_home.php"><input type="button" value="Volver Al Inicio" /></a>
</FORM>
<?php
//session_start();
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])){
	$cookie_name = "array";
	$conn = conexion();
	$producto = test_input($_POST['producto']);
	$cantidad = test_input($_POST['cantidad']);
	//$array = add_cesta_session($conn,$producto,$cantidad);
	$array = add_cesta_cookie($conn,$producto,$cantidad,$cookie_name);
	$tabla = mostrar_cesta($conn,$array);
	echo $tabla;
	//var_dump($array);
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

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['end'])){
	$nif = test_input($_COOKIE['nif']);
	try {
		$conn = conexion();
		$array = unserialize($_COOKIE["array"]);
		//$array = $_SESSION['array'];
		insert_compra($conn,$nif,$array);
	}catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}catch(Exception $a){
		echo $a->getMessage();
	}
	$conn = null;
}

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
?>
</FORM>
</BODY>
</HTML>
