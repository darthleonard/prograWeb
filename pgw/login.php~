<?php
session_start();
include("res/fns/fnsBD.php");

// cargar datos de sesion
$v_lineas=file("../cnf.php");
for($v_indice=1; $v_indice<count($v_lineas)-1; $v_indice++){
	$v_datos=explode('%',$v_lineas[$v_indice]);
	$_SESSION[$v_datos[0]] = $v_datos[1];
}

$oBD=new bd($_SESSION['servidorBD'], $_SESSION['usuarioBD'], $_SESSION['pwdBD'], $_SESSION['nombreBD']);
if($oBD->a_conexion!=null){
	$cad = "select * from usuario where usr='".$_REQUEST['usr']."' and pwd='".$_REQUEST['pass'] ."'";
	$oBD->m_consulta($cad);
	if($oBD->a_bandError)
		echo "<center><h1>Error " . $oBD->a_mensError ."</h1></center>";
	else{
		// si el usuario es valido, se guardan las variables de sesion
		if($oBD->a_numRegistros==1){
			$renglon=mysql_fetch_object($oBD->a_resuConsulta);
			$_SESSION['usuario']=$renglon->nombre;
			$_SESSION['usr']=$renglon->usr;
			$_SESSION['id_usr']=$renglon->id;
			$_SESSION['fbUser']=$renglon->fbUser;

			// Actualizar el estado a conectado
			$cad="update usuario set online=1 where nombre='" .$_SESSION['usuario'] ."'";
			$oBD->m_consulta($cad);
			header("location: home.php");
		}else{
			// si no se encuentra el usuario o la contraseña no coincide
			echo "<html>
<head> 
</head>
<body>
	<script>alert('El nombre de usuario y contraseña no coinciden')</script>
	<script>javascript:history.go(-1)</script>
</body>
</html>";
		}
	}
}else
	echo "<br><h1>Error de conexion...</h1>";



?>
