<?php
class doHTML{
	// Imprimir cabeceras de html
	function doHTMLHeader($titulo){
		echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//ES'>
<html>
<head>
	<meta http-equiv='Content-type' content='text/html;charset=UTF-8'>
	<title>DBZ - $titulo</title>
	<link rel='stylesheet' type='text/css' href='res/css/estilos.css' media='all' />
	<link rel='stylesheet' type='text/css' href='res/css/estilosMenu.css' media='all' />
	<script src='res/fns/jquery_1.4.1.js'></script>
</head>
<body>
";
		$this->doChatScripts();
		$this->doMainMenu();
	} // Fin de funcion doHTMLHeader

	// Imprime el nombre de usuario al principio de la pagina
	function header(){
		$usuario='Anonimo';
		if(isset($_SESSION['usuario']))
			$usuario = $_SESSION['usuario'];

		?>
	<center><img src='res/img/banner.png' class='imgBanner'></center>
	<h1>Bienvenid@: <?php echo $usuario ."!"; ?></h1>
		<?php
	}

	function doMainMenu(){
		$this->header();
		echo "
	<ul id='tabnav'>
	<li class='tab1'><a href='home.php'>Home</a></li>
	<li class='tab2'><a href='links.php'>Links</a></li>
	<li class='tab3'><a href='mensajes.php'>Mensajes</a></li>
	<li class='tab4'><a href='perfil.php'>Perfil</a></li>
	<li class='tab4'><a href='buscar.php'>Buscar</a></li>
	<li class='tab4'><a href='logout.php'>Salir</a></li>
</ul>
";
	} // Fin de funcion doMainMenu

	// Imprimir pie de pagina
	function doHTMLFooter(){
		$this->doChat();
		echo "</body>
</html>";
	} // Fin de funcion doHTMLFooter

	// Funcion para mostrar el chat
	function doChat(){
?>

<div class='Chat'>
<fieldset>
<legend>Chat</legend>
<table>
	<tr>
		<td>
			
		</td>
		<td>
			<div id='moChat' style="cursor:pointer;">
				<img src='res/img/chat/abrirChat.png'>
			</div>
		</td>
		<td>
			<div id='ocChat' style="display:none; cursor:pointer;">
				<img src='res/img/chat/cerrarChat.png'>
			</div>
		</td>
	</tr>
</table>

<div id='frameChat' style="display:none;">
	<div id='online'>
		
	</div>
	<input type='text'>
	<input type='button' value='enviar'>
</div>

</fieldset>
</div> <!-- fin del div de clase chat -->
<?
	} // Fin de funcion doChat

	// Funcion para escribir los scropts del chat
	function doChatScripts(){
?>
<!-- Mostrar y ocultar usuarios conectados -->
<script type="text/javascript">
	$(document).ready(
		function(){
			$('#ocChat').click(
				function(){
					$('#frameChat').fadeOut(1000)
					$('#ocChat').hide();
					$('#moChat').show(1000);
				}
			);
			$('#moChat').click(
				function(){
					$('#frameChat').fadeIn(1000)
					$('#moChat').hide();
					$('#ocChat').show(1000);
				}
			);
		} // fin de la primera funcion
	); // fin de la funcion ready
</script>

<!-- Actualizar chat -->
<script language="javascript" type="text/javascript">
	var RequestObject = false;
	// el tiempo X que tardará en actualizarse 
	window.setInterval("actualizacion_reloj()", 500);

	if (window.XMLHttpRequest)
		RequestObject = new XMLHttpRequest();
	if (window.ActiveXObject)
		RequestObject = new ActiveXObject("Microsoft.XMLHTTP");

	function ReqChange() { 
	// Si se ha recibido la información correctamente
		if (RequestObject.readyState==4) {
			// si la información es válida 
			if (RequestObject.responseText.indexOf('invalid') == -1) {
				// Buscamos la div con id online 
				document.getElementById("online").innerHTML = RequestObject.responseText;
			} else { 
			// Por si hay algun error document.getElementById("online").innerHTML = "Error llamando"; 
			}
		} 
	}

	function actualizarEstadosUsuarios() {
		// Mensaje a mostrar mientras se obtiene la información remota...
		document.getElementById('online').innerHTML = ''; 
		// Preparamos la obtención de datos
		RequestObject.open('GET', 'http://localhost/pgw/res/fns/actualizarOnline.php', true);
		RequestObject.onreadystatechange = ReqChange; 
		// Enviamos
		RequestObject.send(null);
	}

	function actualizacion_reloj() {
		actualizarEstadosUsuarios();
	}
</script>
<!-- Fin del metodo de actualizar chat -->

<?
	} // fin de funcion doChatScripts
}

?>
