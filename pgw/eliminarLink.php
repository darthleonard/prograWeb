<?
session_start();
require_once('LinkMngr.php');
if(isset($_SESSION['usuario'])){

	// verificar que sse haya seleccionado algun elemento
	if(isset($_REQUEST['linkID'])){
		// recorrer el arreglo
		foreach($_REQUEST['linkID'] as $id){
			$o_lm = new ManejadorLinks();
			$o_lm->eliminarLink($id);
		}
		header("location: links.php");
	}else
		echo "isset false";
}else
	header("location: index.html");
?>
