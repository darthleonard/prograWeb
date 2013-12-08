<?php
session_start();
require('fnsBD.php');
$oBD=new bd($_SESSION['servidorBD'], $_SESSION['usuarioBD'], $_SESSION['pwdBD']);
if($oBD->a_conexion!=null){
	//$oBD->m_seleBD('ppw');
	$cad = "select * from usuario";
	$oBD->m_consulta($cad);
	if($oBD->a_bandError)
		echo "<center><error>Error " . $oBD->a_mensError ."<error></center>";
	else{

		echo "<table border='1'>";
		echo "<tr>";
			echo "<td>";
			echo "espacio chat";
			echo "</td>";

			echo "<td>";
			echo "<table>";
			while($renglon=mysql_fetch_object($oBD->a_resuConsulta)){
				if($renglon->nombre != $_SESSION['usuario']){
					echo "<tr>";
					echo "<td>";
					$img = ($renglon->online==0)?"off.png":"on.png";
					echo "<img src='res/img/chat/".$img."'";
					echo "</td>";
					echo "<td>". $renglon->usr ."</td>";
					echo "</tr>";
				}
			}
			echo "</table>";
			echo "</td>";

		echo "</table>";
	}
}else
	echo "<br><h1>Error de conexion<br>al intentar ver<br>usuarios conectados</h1>";


?>
