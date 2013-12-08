<?php
//session_start();
require_once('res/fns/fnsBD.php');
require_once('res/fns/fnsFB.php');

class Buscador {

function Buscador(){
}

function show(){
//if(isset($_SESSION['usuario'])){
	// si recibio un criterio de busqueda
	if($_REQUEST['bsc'] != ""){
		echo "Resultados para: <b>". $_REQUEST['bsc'] . "</b><br><hr>";

		$o_bd = new bd($_SESSION['servidorBD'], $_SESSION['usuarioBD'], $_SESSION['pwdBD']);
		$o_bd->m_seleBD('ppw');
		$query = "select l.link, l.tags, u.usr from Link as l join usuario as u on l.id_usr=u.id where tags LIKE '%". $_REQUEST['bsc'] ."%' and id_tipoInfo=1";

		$o_bd->m_consulta($query);
		// si hubo error en la consulta
		if($o_bd->a_bandError){
			echo "<center><h1>Error " . $o_bd->a_mensError ."</h1></center>";
			echo "<br><br>";
			echo $query;
		}
		
		// Si la consulta tubo exito
		else{
			// Si se encontraron resultados
			if($o_bd->a_numRegistros>=1){
				// crear objeto de funciones del facebook
				$fb = new funcionesFace();

				$v_color1="#cfc";
				$v_color2="#6e6";
				$v_color=$v_color2;
				$v_flag=false;
				$numRenglones = mysql_num_rows($o_bd->a_resuConsulta);
				$numColumnas = mysql_num_fields($o_bd->a_resuConsulta);
				// comenzar construccion de tabla
				echo "<table class='tabla1'>";	
		
				// crear cuerpo de tabla
				for(; $numRenglones>0; $numRenglones--){
				// obtener objeto para sacar informacion
				$registro = mysql_fetch_array($o_bd->a_resuConsulta);
					echo "<tr>";
					$v_nombreLink = explode("/", $registro['link']);
					$v_ext = explode(".", end($v_nombreLink));
					$v_ext[1] = (file_exists('res/img/iconos/'. $v_ext[1] .'.png'))?$v_ext[1]:'desconocido';
					echo "<td bgcolor=$v_color><img src='res/img/iconos/". $v_ext[1] .".png' title='". $v_ext[1] ."'></td>";
					echo "<td bgcolor=$v_color> <a href='". $registro['link'] ."' target='_blank'>". $registro['link'] ."". "</a></td>";
					echo "<td bgcolor=$v_color align='right'>";$fb->doLikeButton($registro['link']);echo "</td>";
					echo "</tr><tr>";
					echo "<td bgcolor=$v_color></td>";
					echo "<td bgcolor=$v_color><descripcionLink>". $registro['tags'] ."</descripcionLink></td>";
					echo "<td bgcolor=$v_color align='right'> <descripcionLink>propietario: ".$registro['usr']."</descripcionLink></td>";
					echo "</tr>";
					$v_flag=!$v_flag;
					($v_flag)?$v_color=$v_color1:$v_color=$v_color2;
				}
				echo "</table>";
			}
			// Si no se encontraron resultados
			else{
				echo "<center>";
				echo "<p class='aviso'>No se encontro nada con <b>". $_REQUEST['bsc'] ."</b>, prueba otra palabra!</p>";
				echo"</center>";
			}
		} // fin else de consulta
		
	}
	//si no se recibio criterio de busqueda
	else
		echo "";

//}else
//	header("location: index.html");
}

}
?>
