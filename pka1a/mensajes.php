<?php
session_start();

// http://vcomputadoras.com/refrescar-diferentes-divs-con-javascript-y-ajax/

if(isset($_SESSION['usuario'])){
?>

<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//ES'>
<html>
<head>
	<meta http-equiv='Content-type' content='text/html;charset=UTF-8'>
	<title>miniChat</title>
	<link rel='stylesheet' type='text/css' href='css/estilos.css' media='all' />
	<script src='jquery_1.4.1.js'></script>
</head>
<body>

<?
	echo "<h1>Bienvenid@ ". $_SESSION['usuario'] ."</h1>";
?>

<!-- Mostrar y ocultar usuarios conectados -->
<script type="text/javascript">
	$(document).ready(
		function(){
			$('#equis').click(
				function(){
					$('#online').fadeOut(1000)
					$('#equis').hide();
					$('#ver').show(1000);
				}
			); // fin de la funcion en equis
			$('#ver').click(
				function(){
					$('#online').fadeIn(1000)
					$('#ver').hide();
					$('#equis').show(1000);
				}
			); // fin de la funcion en equis
		} // fin de la primera funcion
	); // fin de la funcion ready
</script>

<!-- Actualizar lista de usuarios conectados -->
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

			document.getElementById("conversacion").innerHTML = RequestObject.responseText;
			} else { 
			// Por si hay algun error document.getElementById("online").innerHTML = "Error llamando"; 
			}
		} 
	}

	function actualizarConversacion() {
		// Mensaje a mostrar mientras se obtiene la información remota...
		document.getElementById('conversacion').innerHTML = ''; 
		// Preparamos la obtención de datos
		RequestObject.open('GET', 'http://localhost/prograweb/pka1a/fns/actualizarConversacion.php?n='+Math.random(), true);

		RequestObject.onreadystatechange = ReqChange; 
		// Enviamos
		RequestObject.send(null);
	}

	function actualizarEstadosUsuarios() {
		// Mensaje a mostrar mientras se obtiene la información remota...
		document.getElementById('online').innerHTML = ''; 
		// Preparamos la obtención de datos
		RequestObject.open('GET', 'http://localhost/prograweb/pka1a/fns/actualizarOnline.php', true);
		RequestObject.onreadystatechange = ReqChange; 
		// Enviamos
		RequestObject.send(null);
	}

	function actualizacion_reloj() {
		actualizarConversacion();
		actualizarEstadosUsuarios();
	}
</script>
<!-- Fin del metodo de actualizar lista de usuarios conectados -->




<table>
	<tr>
		<td>
			<!-- espacio mensajes -->
			<div id='conversacion' class='divChat' style="overflow-y: scroll;">
			<!-- <textarea rows="10" cols="40" readonly="readonly" style="background-color:#9e9";></textarea> -->
			</div>
		</td>
		<td rowspan='2'>
			<!-- tabla para mostrar usuarios conectados -->
			<table>
				<tr>
					<td>
						<div id='ver' style="display:none; cursor:pointer;">
							<center><h6>Mostrar lista de usuarios</h6></center>
						</div>
					</td>
					<td>
						<div id='equis' style="cursor:pointer;">
							<center><h6>Ocultar lista de usuarios</h6></center>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan='2'>
						<div id='online' class='divBordeA'></div>
					</td>
				</tr>
			</table>
			<!-- fin de tabla para mostrar usuarios conectados -->

		</td>
	</tr>
	<tr>
		<td>
			<center>
			<input type='text'/>
			<button type='button' onclick='loadXMLDoc()'>Enviar</button>
			</center>
		</td>
	</tr>
</table>

<br>
<hr>
<a href='logout.php'>Salir</a>

</body>
</html>





<?
}else
	header("location: index.html");
?>
