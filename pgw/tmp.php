<?php
@$value = $_REQUEST['n'];
@$value2 = $_REQUEST['m'];

if($value == null) {
	?>
	<script language="javascript">
	alert("Alerta! se redireccionara");
	</script>
	<?php
	header('location:tmp.php?n=usuario&m=password');
}
else{
	echo "se recibio ". $_REQUEST['n'] ." y " .$_REQUEST['m'];
}

/*
if($value == null) {
	?>
	<script language="javascript">
	alert("Alerta!");
	</script>
	<?php
	echo "mostrado despues del script";
}
else{
	echo "se recibio null";
}
*/
?>
