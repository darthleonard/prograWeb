<?
session_start();
include("res/fns/fnsBD.php");

$camposIncorrectos="Campos Incorrectos: ";

$mail = $_REQUEST['mail'];
$flag=true;
if($_REQUEST['nom'] > '')
	if($_REQUEST['ape'] > '')
		if($_REQUEST['mail'] > '' && preg_match("/^[^@]*@[^@]*\.[^@]*$/",$mail))
			if($_REQUEST['pass'] > '')
				if($_REQUEST['pass'] == $_REQUEST['passCmp'])
					if(preg_match("/^[[:digit:]]+$/", $_REQUEST['edad']) && $_REQUEST['edad']>''){
						$flag=false;
						registra();
					}else
						$camposIncorrectos .= ", Edad<br>";
				else
					$camposIncorrectos .= "password no coincide, <br>";
			else
				$camposIncorrectos .= "password vacio<br>";
		else
			$camposIncorrectos .= "mail no valido<br>";
	else
		$camposIncorrectos .= "apellido vacio<br>";
else
	$camposIncorrectos .= "nombre vacio<br>";

if($flag){
	echo $camposIncorrectos;
	echo "<a href='formularioRegistro.html'>intenta nueva mente</a>";
}

function registra(){
	$v_lineas=file("res/pjinfo/cnf.php");
	for($v_indice=1; $v_indice<count($v_lineas)-1; $v_indice++){
		$v_datos=explode('%',$v_lineas[$v_indice]);
		$_SESSION[$v_datos[0]] = $v_datos[1];
	}
	
	$oBD=new bd($_SESSION['servidorBD'], $_SESSION['usuarioBD'], $_SESSION['pwdBD']);
	if($oBD->a_conexion!=null){
		$oBD->m_seleBD('ppw');
		$cad = "insert into usuario(usr,pwd,nombre,apellidos,correo,edad) values('".$_REQUEST['usr']."','".$_REQUEST['pass']."','".$_REQUEST['nom']."','".$_REQUEST['ape']."','".$_REQUEST['mail']."',".$_REQUEST['edad'].")";
		$oBD->m_consulta($cad);
		if($oBD->a_bandError){
			echo "<center><h1>Error " . $oBD->a_mensError ."</h1></center>";
			echo "<br><error>Lo sentimos, <a href='formularioRegistro.html'>intenta nueva mente</a><error>";
		}else{
			header("location: login.php?usr=". $_REQUEST['usr'] ."&pass=".$_REQUEST['pass']);
		}
	}else{
		echo "<br><h1>Error de conexion...</h1>";
		echo "<br>Lo sentimos, <a href='formularioRegistro.html'>intenta nueva mente</a>";
	}
}

?>
