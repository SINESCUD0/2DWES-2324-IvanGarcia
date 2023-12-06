<HTML>
<HEAD> <TITLE>Base Datos</TITLE>
</HEAD>
<BODY>
<h1>ALTA CATEGORIAS</h1>
<form name='mi_formulario' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
Nombre Categoria:
<input type='text' name='categoria' value=''></br></br>
<input type="submit" value="Crear">
<input type="reset" value="Borrar">
</FORM>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$nombre = test_input($_POST['categoria']);
	
	$servername = "localhost";
	$username = "root";
	$password = "rootroot";
	$dbname = "COMPRASWEB";

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		insert_categoria($conn,$nombre);

		echo "New records created successfully";
		}
	catch(PDOException $e)
		{
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

function insert_categoria($conn,$nombre){
	$id = '';
	$stmt = $conn->prepare("SELECT COUNT(ID_CATEGORIA) AS NUMERO_IDS FROM CATEGORIA");
    $stmt->execute();
	
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$resultado=$stmt->fetchAll();
	
	foreach($resultado as $row){
        $cont = $row['NUMERO_IDS'] + 1;
		$num = str_pad($cont, 3, '0', STR_PAD_LEFT);
        $id = "C" . "-" . $num;
    }
	
	$stmt = $conn->prepare("INSERT INTO CATEGORIA (ID_CATEGORIA,NOMBRE) VALUES (:id,:nombre)");
	$stmt->bindParam(':id', $id);
	$stmt->bindParam(':nombre', $nombre);
	$stmt->execute();
}
?>
</FORM>
</BODY>
</HTML>