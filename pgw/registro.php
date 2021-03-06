<?
session_start();
include("res/fns/fnsBD.php");

$mail = $_REQUEST['mail'];

// verificar los campos del formulario
if($_REQUEST['nom'] > '')
	if($_REQUEST['ape'] > '')
		if($_REQUEST['mail'] > '' && preg_match("/^[^@]*@[^@]*\.[^@]*$/",$mail))
			if($_REQUEST['pass'] > '')
				if($_REQUEST['pass'] == $_REQUEST['passCmp'])
					if(preg_match("/^[[:digit:]]+$/", $_REQUEST['edad']) && $_REQUEST['edad']>'')
						if($_REQUEST['usr'])
							registra();
						else
							rechazarRegistro(1,'usuario');	
					else
						rechazarRegistro(1,'edad');
				else
					rechazarRegistro(1,'password no coincide');
			else
				rechazarRegistro(1,'password');
		else
			rechazarRegistro(1,'mail');
	else
		rechazarRegistro(1,'apellido');
else
	rechazarRegistro(1,'nombre');

/*
 * funcion para registrar un usuario
 */
function registra(){
	$v_lineas=file("../cnf.php");
	for($v_indice=1; $v_indice<count($v_lineas)-1; $v_indice++){
		$v_datos=explode('%',$v_lineas[$v_indice]);
		$_SESSION[$v_datos[0]] = $v_datos[1];
	}
	
	$oBD=new bd($_SESSION['servidorBD'], $_SESSION['usuarioBD'], $_SESSION['pwdBD'], $_SESSION['nombreBD']);
	if($oBD->a_conexion!=null){
		// validar el nombre de usuario
		if(validaUsuario($oBD,$_REQUEST['usr'])){
			$cad = "insert into usuario(usr,pwd,nombre,apellidos,correo,fbUser,edad) values('".$_REQUEST['usr']."','".$_REQUEST['pass']."','".$_REQUEST['nom']."','".$_REQUEST['ape']."','".$_REQUEST['mail']."','". $_REQUEST['fbUsr'] ."',".$_REQUEST['edad'].")";
			$oBD->m_consulta($cad);
			if($oBD->a_bandError){
				rechazarRegistro(-1, $oBD->a_mensError);
			}else{
				$id_tmp = 0;
				$cad = "select id form usuario where usr='". $_REQUEST['usr'] ."')";
				$oBD->m_consulta($cad);
				if($oBD->a_numRegistros==1){
					$renglon=mysql_fetch_object($oBD->a_resuConsulta);
					$id_tmp = $renglon->id;
				}
				$cad = "insert into Registro(id_usr) values(".$id_tmp.")";
				$oBD->m_consulta($cad);
				header("location: login.php?usr=". $_REQUEST['usr'] ."&pass=".$_REQUEST['pass']);
			}
		}
		// si no es valido, rechazar registro
		else{
			rechazarRegistro(0);
		}
	}else{
		rechazarRegistro(-1,'Error de conexion, por favor, intenta nuevamente');
	}
} // fin de funcion registra

/* verifica que el nombre de usuario no este en la base de datos
 * $oBD -> objeto para realizar consulta y buscar el nombre de usuario
 * $nombre -> nombre de usuario a comprobar
 */
function validaUsuario($oBD, $nombre=''){
	$query = "select usr from usuario where usr='".$nombre."'";
	$oBD->m_consulta($query);
	if($oBD->a_bandError)
		rechazarRegistro(-1, $oBD->a_mensError);
	if($oBD->a_numRegistros>=1){
		return false;
	}else{
		return true;
	}
} // fin del metodo validaUsuario

/*
 * cancela el registro y regresa al formulario
 * $op -> selector de motivo del rechazo de la solicitud
 * $campo -> campo que no paso la verificacion
 */
function rechazarRegistro($op='', $campo=''){
	switch($op){
		case 0:
			echo "<script>alert('El nombre de usuario no esta disponible')</script>";
			echo "<script>javascript:history.go(-1)</script>";
		break;
		case 1:
			echo "<script>alert('".$campo.": valor no aceptado')</script>";
			echo "<script>javascript:history.go(-1);</script>";
		break;
			echo "<script>alert('".$campo."')</script>";
		default:
	}
} // fin del metodo rechazaUsuario

?>
