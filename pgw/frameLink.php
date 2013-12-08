<?php

$link = "".$_REQUEST['pagina'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 2.0 //ES">
<html>
<head>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
	<title></title>
</head>

<frameset rows=80%,* frameborder='no'>
		<frame name='trabajo' <? echo "src='". $link ."'"; ?> /></frame>
		<frame name='menu' src='menu.html' scrolling='no' /></frame>
</frameset>

</html>

<?
?>
