<?php
require('res/fns/fnsHTML.php');
require('LinkMngr.php');

$o_html = new doHTML();
$o_html->doHTMLHeader('Links');

if(isset($_SESSION['usuario'])){
	$lm = new ManejadorLinks();
	?>
	<table class='tabla1'>
		<tr>
			<td><div class='Contenido'> <? $lm->mostrarLinks(0); ?> </div></td>
			<td><div class='Contenido'> <? $lm->mostrarFormularioNuevo(); ?> </div></td>
		</tr>
	</table>
	<?	
}else
	header("location: index.html");

$o_html->doHTMLFooter();
