<?php
$decimal = test_input($_POST['decimal']);
echo "<h1> CONVERSOR BINARIO </h1>";
echo "Numero decimal: $decimal <br/>";
$binario = "";
$num = $decimal;
while($num != 0){
	$binario .= intval($num) % 2;
	$num = intval($num)/2;
}
$binario = strrev($binario);
if($binario[0] == 0){
	$binario = substr($binario,1); 
}
echo "Numero binario: $binario";

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>