<HTML>
<HEAD><TITLE> EJ4B – Tabla Multiplicar</TITLE>
<STYLE>
table {
  border-collapse: collapse;
}
td{
  border: 1px solid black;
  text-align: left;
  padding: 8px;
}
</STYLE>
</HEAD>
<BODY>
<?php
$num="120";
$tabla = "<table>";
for($i = 1; $i<=10; $i++){
	$resultado = $num * $i;
	$tabla .= "<tr> <td>$num x $i </td><td>$resultado</td></tr>";
}
echo $tabla."</table>";
?>
</BODY>
</HTML>