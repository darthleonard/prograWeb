<?php
session_start();
require_once('res/fns/fnsHTML.php');
require_once('BuscadorMngr.php');

$o_html = new doHTML();
$o_html->doHTMLHeader('Buscador de Links');

if(isset($_SESSION['usuario'])){
	?>
	<form action='' method=post>
		<align='left'><input type=text name='bsc'>
		<input type=submit value="buscar">
	</form>
	<br>
	<?
	if(isset($_REQUEST['bsc'])){
		$o_ssr = new Buscador();
		$o_ssr->show();
	}
}else
	header("location: index.html");

$o_html->doHTMLFooter();
?>
