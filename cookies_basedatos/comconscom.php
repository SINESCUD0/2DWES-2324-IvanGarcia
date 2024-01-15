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
Fecha desde:
<input type="date" name="desde">
<br/><br/>
Fecha hasta:
<input type="date" name="hasta">
<br/><br/>
<input type="submit" value="Consulta">
<input type="reset" value="Borrar">
<a href="login_home.php"><input type="button" value="Volver Al Inicio" /></a>
</FORM>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$nif = test_input($_COOKIE['nif']);
	$fechaIni = test_input($_POST['desde']);
	$fechaFin = test_input($_POST['hasta']);

	try {
		$conn = conexion();
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
			$gasto += $row2['PRECIO'];
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
					$tabla .= "<td>".$array[0][$i][$x]."€</td>";
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
?>
</FORM>
</BODY>
</HTML>