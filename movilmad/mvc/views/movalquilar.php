<html>
   
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>Bienvenido a MovilMAD</title>
    <link rel="stylesheet" href="http://192.168.206.222/movilmad/mvc/public/css/bootstrap.min.css">
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
		<div class="card-header">Menú Usuario - ALQUILAR VEHÍCULOS</div>
		<div class="card-body">
	  	  

	<!-- INICIO DEL FORMULARIO -->
	<form action="" method="post">
	
		<B>Bienvenido/a:</B> <?php echo $nombre." ".$apellido ?> <BR><BR>
		<B>Identificador Cliente:</B><?php echo $id ?><BR><BR>
		
		<B>Vehiculos disponibles en este momento:</B> <?php echo $fecha ?>  <BR><BR>
		
		<B>Matricula/Marca/Modelo: </B>
		<select name="vehiculos" class="form-control">
			<?php
				foreach($select as $matricula => $valores){
					echo "<option value=\"$matricula\">$matricula / $valores[0] / $valores[1]</option>";
				}
			?>
		</select>
		<BR> <BR><BR><BR><BR><BR>
		<div>
			<input type="submit" value="Agregar a Cesta" name="agregar" class="btn btn-warning disabled">
			<input type="submit" value="Realizar Alquiler" name="alquilar" class="btn btn-warning disabled">
			<input type="submit" value="Vaciar Cesta" name="vaciar" class="btn btn-warning disabled">
			<input type="submit" value="Volver" name="volver" class="btn btn-warning disabled">
		</div>
	</form>
	<?php
		
	?>
	<!-- FIN DEL FORMULARIO -->
  </body>
   
</html>

