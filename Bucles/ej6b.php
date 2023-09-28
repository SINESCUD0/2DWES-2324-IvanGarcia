<HTML>
<HEAD><TITLE> EJ6B – Factorial</TITLE></HEAD>
<BODY>
<?php
$num=5;
$resultado = 1;
for($i = 1; $i <= $num; $i++){
	$resultado = $resultado * $i;
}
echo "Factorial de !$num = $resultado";
?>
</BODY>
</HTML>