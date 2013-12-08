<?php
session_start();
require_once('res/fns/fnsHTML.php');
require_once('BuscadorMngr.php');

$o_html = new doHTML();
$o_html->doHTMLHeader('Buscador de Links');

if(isset($_SESSION['usuario'])){
	// Formulario para ingresar el criterio de busqueda
	?>
	<form action='' method=post>
		<align='left'><input type=text name='bsc'>
		<input type=submit value="buscar">
	</form>
	<br>
	<?
	/*
	 * si hay criterio de busqueda, crea el objeto y llama a metodo show
	 */
	if(isset($_REQUEST['bsc'])){
		$o_ssr = new Buscador();
		$o_ssr->show();
	}
}else
	header("location: index.html");

$o_html->doHTMLFooter();
?>
