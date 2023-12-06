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
<h1>CONSULTA COMPRAS</h1>
<form name='mi_formulario' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
NIF Cliente:
<select name="cliente">
<?php
	$servername = "localhost";
	$username = "root";
	$password = "rootroot";
	$dbname = "COMPRASWEB";
	
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$array = array();
		$array = cargar_cliente($conn);
		
		foreach ($array as $nif) {
			echo "<option value=\"$nif\">$nif</option>";
		}
		
	}catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
	$conn = null;
?>
</select>
<br/><br/>
Fecha desde:
<input type="date" name="desde">
<br/><br/>
Fecha hasta:
<input type="date" name="hasta">
<br/><br/>
<input type="submit" value="Consulta">
<input type="reset" value="Borrar">
</FORM>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$nif = test_input($_POST['cliente']);
	$fechaIni = test_input($_POST['desde']);
	$fechaFin = test_input($_POST['hasta']);

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$mostrar = consulta_almacen($conn,$nif,$fechaIni,$fechaFin);
		mostrar_pantalla($mostrar,$nif);
	}catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
	$conn = null;
	
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
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
		$stmt = $conn->prepare("SELECT NOMBRE, PRECIO FROM PRODUCTO WHERE ID_PRODUCTO = :id_producto");
		$stmt->bindParam(':id_producto',$row['ID_PRODUCTO']);
		$stmt->execute();
		
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$resultado2=$stmt->fetchAll();
		foreach($resultado2 as $row2) {
			$array[] = [$row['ID_PRODUCTO'],$row2['NOMBRE'],$row2['PRECIO'],$row['UNIDADES']];
			$gasto += $row2['PRECIO'];
		}
	}
	$gastos[] = $gasto;
	return [$array,$gastos];
}

function mostrar_pantalla($array,$nif){
	if(empty($array[0])){
		echo "El cliente con nif " . $nif . " no ha hecho ninguna compra en ese rango de fecha.";
	}else{
		echo "Compras del cliente con nif " . $nif . ":<br/>";
		$tabla = "<table><tr><td>ID PRODUCTO</td><td>NOMBRE</td><td>PRECIO</td><td>CANTIDAD</td></tr>";
		for($i = 0; $i < count($array[0]); $i++){
			$tabla .= "<tr>";
			for($x = 0; $x < count($array[0][$i]); $x++){
				$tabla .= "<td>".$array[0][$i][$x]."</td>";
			}
			$tabla .= "</tr>";
		}
		$tabla .= "<td>GASTOS TOTALES</td><td>".$array[1][0]."</td>";
		$tabla .= "</table>";
		echo $tabla;
	}
}

function cargar_cliente($conn){
	$stmt = $conn->prepare("SELECT NIF FROM CLIENTE");
	$stmt->execute();
	
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$resultado=$stmt->fetchAll();
	foreach($resultado as $row) {
		$array[] = $row['NIF'];
	}
	return $array;
}
?>
</FORM>
</BODY>
</HTML>