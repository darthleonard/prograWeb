<?php
session_start();
require('fnsBD.php');
$oBD=new bd($_SESSION['servidorBD'], $_SESSION['usuarioBD'], $_SESSION['pwdBD']);
if($oBD->a_conexion!=null){
	$oBD->m_seleBD('pka');
	$cad = "select * from Usuario";
	$oBD->m_consulta($cad);
	if($oBD->a_bandError)
		echo "<center><h1>Error " . $oBD->a_mensError ."</h1></center>";
	else{
		echo "<table>";
		while($renglon=mysql_fetch_object($oBD->a_resuConsulta)){
			if($renglon->nombre != $_SESSION['usuario']){
				echo "<tr>";
				echo "<td>";
				$img = ($renglon->online==0)?"off.png":"on.png";
				echo "<img src='img/".$img."'";
				echo "</td>";
				echo"	<td>". $renglon->nombre ."</td>";
				echo"</tr>";}
		}
		echo"</table>";
	}
}else
	echo "<br><h1>Error de conexion<br>al intentar ver<br>usuarios conectados</h1>";

?>
