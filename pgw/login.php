<?php
session_start();
include("res/fns/fnsBD.php");

$v_lineas=file("res/pjinfo/cnf.php");
for($v_indice=1; $v_indice<count($v_lineas)-1; $v_indice++){
	$v_datos=explode('%',$v_lineas[$v_indice]);
	$_SESSION[$v_datos[0]] = $v_datos[1];
	//echo $v_datos[1] ."<br>";
}

$oBD=new bd($_SESSION['servidorBD'], $_SESSION['usuarioBD'], $_SESSION['pwdBD']);
if($oBD->a_conexion!=null){
	$oBD->m_seleBD('ppw');
	$cad = "select * from usuario where usr='".$_REQUEST['usr']."' and pwd='".$_REQUEST['pass'] ."'";
	$oBD->m_consulta($cad);
	if($oBD->a_bandError)
		echo "<center><h1>Error " . $oBD->a_mensError ."</h1></center>";
	else{
		if($oBD->a_numRegistros==1){
			$renglon=mysql_fetch_object($oBD->a_resuConsulta);
			//echo "<br><br> nombre: ". $renglon->nombre ."<br><br>";
			$_SESSION['usuario']=$renglon->nombre;
			$_SESSION['usr']=$renglon->usr;
			$_SESSION['id_usr']=$renglon->id;
			$_SESSION['fbUser']=$renglon->fbUser;

			$cad="update usuario set online=1 where nombre='" .$_SESSION['usuario'] ."'";
			$oBD->m_consulta($cad);
			//echo "<br><br> sesion: ". $_SESSION['usuario'] ."<br><br>";
			header("location: home.php");
		}else{
			echo "<html>
<head> 
<script type='text/javascript'>
  alert('Usuario y contraseña no coinciden');
	location.href = 'index.html';
</script>
</head>
<body>
</body>
</html>";
//			header("location: index.html");
		}
	}
}else
	echo "<br><h1>Error de conexion...</h1>";



?>
