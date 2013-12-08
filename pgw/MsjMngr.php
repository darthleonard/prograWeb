<?php
require_once('res/fns/fnsBD.php');

class manejadorMensajes {
	function manejadorMensajes(){

	}

	/** valids si el usuario al que se le enviara el mensaje existe
	 *  param  $usrTg: el nombre de usuario del destinatario
	 *  return true: si existe | false si no existe
	 */
	function validaUsuario($usrTg){
		$o_bd = new bd($_SESSION['servidorBD'], $_SESSION['usuarioBD'], $_SESSION['pwdBD']);
		$o_bd->m_seleBD('ppw');
		$query = "select * from usuario where usr='". $usrTg ."'";
		$o_bd->m_consulta($query);
		if($o_bd->a_bandError)
			echo "<center><error>Error " . $o_bd->a_mensError ."</error></center>";
		else{
			if($o_bd->a_numRegistros==1){
				return true;
			}else{
				return false;
			}
		}
	}

	// Metodo para enviar un nuevo mensaje
	function enviarNuevo(){
		$o_bd = new bd($_SESSION['servidorBD'], $_SESSION['usuarioBD'], $_SESSION['pwdBD']);
		$o_bd->m_seleBD('ppw');

		// obtener el id del usuario que envia el mensaje
		$query = "select id from usuario where usr='". $_SESSION['usr'] ."'";
		$o_bd->m_consulta($query);
		$registro = mysql_fetch_array($o_bd->a_resuConsulta);
		$idUsrOr = $registro['id'];

		// obtener el id del usuario que recibira el mensaje
		$query = "select id from usuario where usr='". $_REQUEST['usr'] ."'";
		$o_bd->m_consulta($query);
		$registro = mysql_fetch_array($o_bd->a_resuConsulta);
		$idUsrTg = $registro['id'];

		// Consulta final para enviar el mensaje
		$query = "insert into Mensaje(id_usrOr, id_usrTg, id_tipoInfo, msj) values (".$idUsrOr.",". $idUsrTg. ",". $_REQUEST['tipo'] .",'". $_REQUEST['msj'] ."')";
		$o_bd->m_consulta($query);
		if($oBD->a_bandError){
			echo "<center><error>Error " . $oBD->a_mensError ."</error></center>";
			echo "<a href='mensajes.php'>Regresar</a>";
		}
		else
			header("location: mensajes.php");

	}// Fin de metodo enviarNuevo

	/* Funcion para eliminar un lMensaje
	 * $id -> el id del Mensaje que sera eliminado
	 */
	function eliminarMensaje($id){
		$o_bd = new bd($_SESSION['servidorBD'], $_SESSION['usuarioBD'], $_SESSION['pwdBD']);
		$query = "delete from Mensaje where id = ". $id;
		//echo $query ."<br>";
		$o_bd->m_consulta($query);
		if($o_bd->a_bandError){
			echo "<center><error>Error " . $o_bd->a_mensError ."</error></center>";
			echo "<br><br>";
			echo $query;
			exit;
		}
	} // Fin de funcion eliminarMensaje

	/* Funcion para mostrar los mensajes Recibidos
	 * $p_tipoInfo -> 0 para mostrar los mensajes privados | 1- para mostrar los mensajes publicos 
	 */
	function mostrarMensajes($p_tipoInfo){
		$oBD=new bd($_SESSION['servidorBD'], $_SESSION['usuarioBD'], $_SESSION['pwdBD']);
		if($oBD->a_conexion!=null){
			$v_flagQuery;
			$v_flagQuery=($p_tipoInfo==0)?false:true;
			$oBD->m_seleBD('ppw');
			if($v_flagQuery)
				$query = "select m.id, u.usr, m.msj, m.fecha from Mensaje as m join usuario as u on m.id_usrOr=u.id where id_usrTg=(select id from usuario where usr='". $_SESSION['usr'] ."') and id_tipoInfo=$p_tipoInfo";
			else
				$query = "select m.id, u.usr, m.msj, m.fecha, t.tipo from Mensaje as m join tipoInfo as t on t.id=m.id_tipoInfo join usuario as u on m.id_usrOr=u.id where m.id_usrTg=(select id from usuario where usr='". $_SESSION['usr'] ."')";

			echo "<fieldset><legend>Mensajes</legend>";

			$oBD->m_consulta($query);
			if($oBD->a_bandError)
				echo "<center><h1>Error " . $oBD->a_mensError ."</h1></center>";
			else{
				if($oBD->a_numRegistros>=1){
					$v_color1="#cfc";
					$v_color2="#6e6";
					$v_color=$v_color2;
					$v_flag=false;
					echo "<form action='eliminarMensaje.php'><table cellspacing='0' cellpadding='5'>";
					if(!$v_flagQuery)
						echo "<tr><th>remitente</th><th>Mensaje</th><th>fecha</th><th>tipo</th><th>marcar</th></tr>";
					else
						echo "<tr><th>remitente</th><th>Mensaje</th><th>fecha</th></tr>";
					while($renglon=mysql_fetch_object($oBD->a_resuConsulta)){
						echo "<tr>";
						echo "<td bgcolor=$v_color>". $renglon->usr ."</a></td>";
						echo "<td bgcolor=$v_color>". $renglon->msj ."</a></td>";
						echo "<td bgcolor=$v_color>". $renglon->fecha ."</td>";
						if(!$v_flagQuery){
							echo "<td bgcolor=$v_color>". $renglon->tipo ."</td>";
							echo "<td bgcolor=$v_color align='center'><input type=checkbox value=". $renglon->id ." name='msjID[]'></td>";
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
					echo "<br>No tienes ningun mensaje, <a href='mensajes.php'>Envia uno!!</a>";
				}
			echo "</fieldset>";
			}
		}else
			echo "<br><center><h1>Error de conexion...</h1><center>";

	}// Fin de funcion showMessages

	// Metodo para mostrar el formulario de envio de un nuevo mensaje
	function mostrarFormularioEnvio(){
?>
	<form action='enviarMensaje.php' method=post>
	<fieldset>
		<legend>Enviar Nuevo</legend>
		<table border=0 align=center>
			<tr>
				<td align='right'>para&nbsp;</td>
				<td align='left'><input type=text name=usr></td>
			</tr>
			<tr>
				<td colspan='2' align='left'><textarea rows="10" cols="40" name=msj>Me agradan tus links!</textarea></td>
			</tr>
			<tr>
				<td align="right">Publico</td>
				<td align="left"><input type=radio name="tipo" value='1'></td>

			</tr>
			<tr>
				<td align="right">Privado</td>
				<td align="left"><input type=radio name="tipo" value='2' checked></td>
			</tr>
				<tr>
				<td align='right' colspan=1><input type=submit value="enviar"></td>
			</tr>
		</table>
	</fieldset>
	</form>
<?
	}

}

?>
