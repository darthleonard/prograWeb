<?php
session_start();
require_once('MsjMngr.php');
if(isset($_SESSION['usuario'])){
	if($_REQUEST['msj']==""){
		echo "<center><error>no hay mensaje... ";
		echo "<a href='mensajes.php'>Regresar</a></error></center>";
		exit;
	}

	$o_mm = new manejadorMensajes();
	if($o_mm->validaUsuario($_REQUEST['usr'])){
		$o_mm->enviarNuevo();
	}else{
		echo "<center><error>destinatario no valido...</error><br>";
		echo "<a href='mensajes.php'>Regresar</a></center>";
		exit;
	}
	
}else
	header("location: index.html");
?>
