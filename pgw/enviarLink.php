<?php
session_start();
require_once('LinkMngr.php');
if(isset($_SESSION['usuario'])){

	// verificar que se recibio un link
	if($_REQUEST['newLink']==""){
		echo "<center><error>no hay link... ";
		echo "<a href='links.php'>Regresar</a></error></center>";
		exit;
	}

	$o_lm = new ManejadorLinks();
	$o_lm->enviarNuevo();
}else
	header("location: index.html");

?>
