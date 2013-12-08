<?php
session_start();
require('res/fns/fnsHTML.php');
require('res/fns/fnsFB.php');
require_once("res/fns/fnsBD.php");

$o_html = new doHTML();
$o_html->doHTMLHeader('Perfil');

if(isset($_SESSION['usuario'])){
	$fb = new funcionesFace();

$oBD=new bd($_SESSION['servidorBD'], $_SESSION['usuarioBD'], $_SESSION['pwdBD']);
if($oBD->a_conexion!=null){
	$cad = "select fbUser from usuario where usr='".$_SESSION['usr']."'";
	$oBD->m_consulta($cad);
	if($oBD->a_bandError)
		echo "<center><h1>Error " . $oBD->a_mensError ."</h1></center>";
	else{
		$renglon=mysql_fetch_object($oBD->a_resuConsulta);
		if($renglon->fbUser > "")
			$fb->doFollowButton($renglon->fbUser);
	}
}else
	echo "<br><error>Error de conexion...</error>";

	?>
<center>

<table>
	<tr>
		<td>
			<img src='res/img/en_construccion.jpg'>
		</td>
		<td>
			<?
				$url="http://".$_SERVER['HTTP_HOST']."".$_SERVER['REQUEST_URI'];
				$fb->doCommentDiv($url);
			?>
		</td>
	</tr>
</table>
</center>

	<?	
}else
	header("location: index.html");

$o_html->doHTMLFooter();
