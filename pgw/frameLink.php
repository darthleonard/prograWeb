<?php

if(isset($_REQUEST['p']))
	$link = "".$_REQUEST['p'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 2.0 //ES">
<html>
<head>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
	<title></title>
</head>

<!-- <frameset rows=80%,* frameborder='no'>
		<!--<frame name='trabajo' <? echo "src='abreLink.php?p=$link'";?> /></frame>-->
		<!--<frame name='trabajo' <? echo "src='http://$link'";?> /></frame>-->
		<center><iframe <? echo "src='http://'".$_REQUEST['p']."'"; ?> width="500" height="500"> </iframe></center>
		<!--<frame name='menu' src='menu.html' scrolling='no' /></frame>-->
<!--</frameset>-->

</html>

<?
?>
