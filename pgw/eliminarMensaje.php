<?
session_start();
require_once('MsjMngr.php');
if(isset($_SESSION['usuario'])){
	// verificar que sse haya seleccionado algun elemento
	if(isset($_REQUEST['msjID'])){
		$o_mm = new ManejadorMensajes();
		// recorrer el arreglo
		foreach($_REQUEST['msjID'] as $id){
			$o_mm->eliminarMensaje($id);
		}
	}
	header("location: mensajes.php");
}else
	header("location: index.html");
?>
