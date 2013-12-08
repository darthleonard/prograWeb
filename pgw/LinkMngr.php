<?php
@ session_start();
require_once('res/fns/fnsBD.php');

class ManejadorLinks {
	/* muestra los links guardados en la base de datos
	 * $p_tipoInfo = 0 -> muestra todos
	 * $p_tipoInfo = 1 -> muestra los publicos
	 */
	function mostrarLinks($p_tipoInfo){;
		$o_BD=new bd($_SESSION['servidorBD'], $_SESSION['usuarioBD'], $_SESSION['pwdBD']);
		if($o_BD->a_conexion!=null){
			$v_flagQuery;
			$v_flagQuery=($p_tipoInfo==0)?false:true;
			$o_BD->m_seleBD('ppw');
			if($v_flagQuery)
				$query = "select * from Link where id_usr=(select id from usuario where usr='". $_SESSION['usr'] ."') and id_tipoInfo=$p_tipoInfo";
			else
				$query = "select l.id, l.link, l.fecha, t.tipo from Link as l join tipoInfo as t on t.id=l.id_tipoInfo where l.id_usr=(select id from usuario where usr='". $_SESSION['usr'] ."')";

			echo "<fieldset><legend>Links</legend>";

			$o_BD->m_consulta($query);
			if($o_BD->a_bandError)
				echo "<center><h1>Error " . $o_BD->a_mensError ."</h1></center>";
			else{
				if($o_BD->a_numRegistros>=1){
					$v_color1="#cfc";
					$v_color2="#6e6";
					$v_color=$v_color2;
					$v_flag=false;
					echo "<form action='eliminarLink.php'><table cellspacing='0' cellpadding='5'>";
					if(!$v_flagQuery)
						echo "<tr><th>tipo</th><th>link</th><th>fecha</th><th>tipo</th><th>marcar</th></tr>";
					else
						echo "<tr><th>tipo</th><th>link</th><th>fecha</th></tr>";
					while($renglon=mysql_fetch_object($o_BD->a_resuConsulta)){
						echo "<tr>";
						$v_nombreLink = explode("/", $renglon->link);
						$v_Ext = explode(".", end($v_nombreLink));
						$v_ext = (file_exists('res/img/iconos/'. end($v_Ext) .'.png'))?end($v_Ext):'desconocido';
						echo "<td bgcolor=$v_color><img src='res/img/iconos/". $v_ext .".png' title='". $v_ext ."'></td>";
						echo "<td bgcolor=$v_color><a href=". $renglon->link ." target='_blank'>". end($v_nombreLink) ."</a></td>";
						echo "<td bgcolor=$v_color>". $renglon->fecha ."</td>";
						if(!$v_flagQuery){
							echo "<td bgcolor=$v_color>". $renglon->tipo ."</td>";
							echo "<td bgcolor=$v_color align='center'><input type=checkbox value=". $renglon->id ." name=linkID[]></td>";
						}
						echo "</tr>";
						$v_flag=!$v_flag;
						($v_flag)?$v_color=$v_color1:$v_color=$v_color2;
					}
					echo "</table>";
					if(!$v_flagQuery)
						echo "<input type='submit' value='Eliminar Seleccionados'>";
					echo "</form>";
				}else{
					echo "<br>No has agregado ningun link, <a href='formularioNuevo.php'>Agrega uno!!</a>";
				}
			}
			echo "</fieldset>";
		}else
			echo "<br><center><h1>Error de conexion...</h1><center>";
	}// Fin de funcion muestraLinks

	// Funcion para agrefar un nuevo Link
	function enviarNuevo(){
		$o_bd = new bd($_SESSION['servidorBD'], $_SESSION['usuarioBD'], $_SESSION['pwdBD']);
		
		$queryValues = "(". $_SESSION['id_usr'] .", ". $_REQUEST['tipoInfo'] .", '". $_REQUEST['newLink'] ."', '" . $_REQUEST['tags'] ."')";
		$query = "insert into Link (id_usr, id_tipoInfo, link, tags) values " . $queryValues;
		//echo "consulta: ". $query;

		$o_bd->m_consulta($query);
		if($o_bd->a_bandError){
			echo "<center><h1>Error " . $o_bd->a_mensError ."</h1></center>";
			echo "<br><br>";
			echo $query;
		}else
			header("location: links.php");

	} // Fin de funcion enviarNuevo

	/* Funcion para eliminar un link
	 * $id -> el id del link que sera eliminado
	 */
	function eliminarLink($id){
		$o_bd = new bd($_SESSION['servidorBD'], $_SESSION['usuarioBD'], $_SESSION['pwdBD']);
		$query = "delete from Link where id = ". $id;
		//echo $query ."<br>";
		$o_bd->m_consulta($query);
		if($o_bd->a_bandError){
			echo "<center><error>Error " . $o_bd->a_mensError ."</error></center>";
			echo "<br><br>";
			echo $query;
			exit;
		}
	} // Fin de funcion eliminarLink

	// mostrar formulario para agregar un nuevo likn
	function mostrarFormularioNuevo(){
?>
	<table class='tabla1' width='100%'>
		<tr>
			<td>
				<form action = 'enviarLink.php' method='post'>
				<fieldset>
					<legend>Agregar un Link nuevo</legend>
			
					<table align='center'>
						<tr>
							<td colspan='2'><input type='text' name='newLink'></td>
						</tr>
						<tr>
							<td colspan='2'><textarea rows="5" cols="40" name='tags'>A&ntilde;ade aqui las palabras clave que identifiquen a tu link, asi m&aacute;s usuarios tendran la oportunidad de apreciarlos!, recuerda separarlos por comas</textarea></td>
						</tr>
						<tr>
							<td><input type='radio' name='tipoInfo' value='1'>publico</td>
							<td><input type='radio' name='tipoInfo' value='2' checked>privado</td>
						</tr>
						<tr>
							<td colspan='2'><input type='submit' value='Aceptar'></td>
						</tr>
					</table>
				</fieldset>
				</form>
			</td>
<!--
			<td>
				<center>
					<img src='res/img/imgSendNewLink.png'>
				</center>
			</td>
-->
		</tr>
	</tabla>
<?
	} // fin de funcion mostrarFormularioNuevo

} // Fin de clase
?>
