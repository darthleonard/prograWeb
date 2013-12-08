<?php
session_start();
require('res/fns/fnsHTML.php');
require('MsjMngr.php');

if(isset($_SESSION['usuario'])){
	$o_html = new doHTML();
	$o_html->doHTMLHeader("Mensajes");

	$mm = new ManejadorMensajes();

?>
	<table class='tabla1'>
		<tr>
			
			<td><div class='Contenido'> <? $mm->mostrarMensajes(0); ?> </div></td>
			<td><div class='Contenido'> <? $mm->mostrarFormularioEnvio() ?> </div></td>

		</tr>
	</table>
<?
	$o_html->doHTMLFooter();

}else
	header("location: index.html");
	
?>
