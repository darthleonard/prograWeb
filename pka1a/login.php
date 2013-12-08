<?php
session_start();
include("fns/fnsBD.php");

$v_lineas=file("pjinfo/cnf.php");
for($v_indice=1; $v_indice<count($v_lineas)-1; $v_indice++){
	$v_datos=explode('%',$v_lineas[$v_indice]);
	$_SESSION[$v_datos[0]] = $v_datos[1];
}

$oBD=new bd($_SESSION['servidorBD'], $_SESSION['usuarioBD'], $_SESSION['pwdBD']);
if($oBD->a_conexion!=null){
	$oBD->m_seleBD('pka');
	$cad = "select * from Usuario where nombre='".$_REQUEST['usr']."' and pwd='".$_REQUEST['pass'] ."'";
	$oBD->m_consulta($cad);
	if($oBD->a_bandError)
		echo "<center><h1>Error " . $oBD->a_mensError ."</h1></center>";
	else{
		if($oBD->a_numRegistros==1){
			$renglon=mysql_fetch_object($oBD->a_resuConsulta);
			$_SESSION['usuario']=$renglon->nombre;

			$cad="update Usuario set online=1 where nombre='" .$_REQUEST['usr'] ."'";
			$oBD->m_consulta($cad);
			if($oBD->a_bandError){
				echo "<center><h1>Error " . $oBD->a_mensError ."</h1><br>no apareceras como conectado</center>";
				exit;
			}

			header("location: mensajes.php");
		}else{
			header("location: index.html");
		}
	}
}else
	echo "<br><h1>Error de conexion...</h1>";

?>
