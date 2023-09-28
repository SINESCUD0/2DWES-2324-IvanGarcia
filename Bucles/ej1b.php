<HTML>
<HEAD><TITLE> EJ1B – Conversor decimal a binario</TITLE></HEAD>
<BODY>
<?php
//$num="168";
//$num="127";
//$num="11";
$num="900";
//$num="348";
$num2 = $num;
$binario = "";
var_dump(intval($num));
while($num != 0){
	$binario .= intval($num) % 2;
	$num = intval($num)/2;
}
$binario = strrev($binario);
if($binario[0] == 0){
	$binario = substr($binario,1); 
}
echo "Numero $num2 en binario = ".$binario;
?>
</BODY>
</HTML>