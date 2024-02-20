<html>
   
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>Bienvenido a MovilMAD</title>
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
	<style>
	td, tr, th{
		text-align: center; 
		border: 1px solid; 
		width: 150px;
	}
	</style>
  </head>
   
 <body>
    <h1>Servicio de ALQUILER DE E-CARS</h1> 

    <div class="container ">
        <!--Aplicacion-->
		<div class="card border-success mb-3" style="max-width: 30rem;">
		<div class="card-header">Menú Usuario - CONSULTA ALQUILERES </div>
		<div class="card-body">
	  
	  	
	   

	<!-- INICIO DEL FORMULARIO -->
	<form action="" method="post">
				
		<B>Bienvenido/a:</B> <?php echo $nombre." ".$apellido ?> <BR><BR>
		<B>Identificador Cliente:</B> <?php echo $id ?><BR><BR>
		     
			 Fecha Desde: <input type='date' name='fechadesde' value='' size=10 placeholder="fechadesde" class="form-control">
			 Fecha Hasta: <input type='date' name='fechahasta' value='' size=10 placeholder="fechahasta" class="form-control"><br><br>
				
		<div>
			<input type="submit" value="Consultar" name="consultar" class="btn btn-warning disabled">
		
			<input type="submit" value="Volver" name="volver" class="btn btn-warning disabled">
		
		</div>
	</form>
	<!-- FIN DEL FORMULARIO -->
    <a href = "../controllers/consultar_controller.php?accion=eliminar">Cerrar Sesion</a>

  </body>
   
</html>
