<?php
session_start();
require('fns/fnsBD.php');
require('destroySession.php');

$oBD=new bd($_SESSION['servidorBD'], $_SESSION['usuarioBD'], $_SESSION['pwdBD']);
if($oBD->a_conexion!=null){
	$oBD->m_seleBD('pka');
	$cad="update Usuario set online=0 where nombre='" .$_SESSION['usuario'] ."'";
	$oBD->m_consulta($cad);
	if($oBD->a_bandError)
		echo "<center><h1>Error " . $oBD->a_mensError ."</h1></center>";
	else
		header("location: index.html");
	
}else
	echo "<br><h1>Error de conexion...</h1>";

?>
