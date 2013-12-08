<?php
session_start();
require_once('LinkMngr.php');
if(isset($_SESSION['usuario'])){

	if($_REQUEST['newLink']==""){
		echo "<center><error>no hay link... ";
		echo "<a href='links.php'>Regresar</a></error></center>";
		exit;
	}

	$o_lm = new ManejadorLinks();
	//if($o_mm->validaUsuario($_REQUEST['usr'])){
		$o_lm->enviarNuevo();
	/*}else{
		echo "<center><error>destinatario no valido...</error><br>";
		echo "<a href='links.php'>Regresar</a></center>";
		exit;
	}*/
	
}else
	header("location: index.html");
?>
