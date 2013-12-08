<?php
session_start();
require('res/fns/fnsHTML.php');
require('MsjMngr.php');
require('LinkMngr.php');

$o_html = new doHTML();
$o_html->doHTMLHeader('Inicio');

if(isset($_SESSION['usuario'])){
	$mm = new ManejadorMensajes();
	$lm = new ManejadorLinks();
	?>
	<table class='tabla1'>
		<tr>
			<div class='Contenido'>
				<td><? $mm->mostrarMensajes(1); ?></td>
			</div>
			<div class='Contenido'>
				<td><? $lm->mostrarLinks(1); ?></td>
			</div>
		</tr>
	</table>
	<?
	
}else
	header("location: index.html");

$o_html->doHTMLFooter();
?>
