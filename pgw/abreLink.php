<!--
<script type="text/javascript">
query=window.location.search.substring(1);
q=query.split("&");
vars=[];
for(i=0;i<q.length;i++){
    x=q[i].split("=");
    k=x[0];
    v=x[1];
    vars[k]=v;
}
</script>
-->


<?php

if(isset($_REQUEST['p'])){
	echo "<a href='https://". $_REQUEST['p'] ."' > abrir </a>";
/*
	echo"
<script language='JavaScript' type='text/javascript'>

var pagina= '".$_REQUEST['p']."';
function redireccionar() {
	alert('redireccionando')
	location.href=pagina
} 
setTimeout ('redireccionar()', 1000);

</script>
";
*/
}
else
	echo "error";
?>
