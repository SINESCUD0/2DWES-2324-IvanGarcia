<HTML>
<HEAD> <TITLE>BOLSA 6</TITLE>
</HEAD>
<STYLE>
table {
  border-collapse: collapse;
}
td, tr{
  border: 1px solid black;
  text-align: left;
  padding: 8px;
}
</STYLE>
<BODY>
<?php
	totales();
	
	function totales(){
		$f1=file("ibex35.txt");
		$totalValores = 0;
		$MaxCotizacion = 0;
		$MinCotizacion = 0;
		$MayVolumen = 0;
		$MenVolumen = 0;
		$MaxCapitalizacion = 0;
		$MinCapitalizacion = 0;
		foreach($f1 as $texto) {
			$filas = preg_split('/\s{2,}/', trim($texto));
			if($filas[0] != "Valor"){
				$totalValores += floatval($filas[1]);
				if($filas[1] > $MaxCotizacion){
					$MaxCotizacion = $filas[1];
				}
				if($filas[1] < $MaxCotizacion){
					$MinCotizacion = $filas[1];
				}
				if($filas[7] > $MayVolumen){
					$MayVolumen = $filas[7];
				}
				if($filas[7] < $MayVolumen){
					$MenVolumen = $filas[7];
				}
				if($filas[8] > $MaxCapitalizacion){
					$MaxCapitalizacion = $filas[8];
				}
				if($filas[8] < $MaxCapitalizacion){
					$MinCapitalizacion = $filas[8];
				}
			}
		}
		echo "Maxima Cotizacion $MaxCotizacion <br/>";
		echo "Minima Cotizacion $MinCotizacion <br/>";
		echo "Mayor Volumen $MayVolumen <br/>";
		echo "Menor Volumen $MenVolumen <br/>";
		echo "Maxima Capitalizacion $MaxCapitalizacion <br/>";
		echo "Minima Capitalizacion $MinCapitalizacion <br/>";
	}
?>
</BODY>
</HTML>