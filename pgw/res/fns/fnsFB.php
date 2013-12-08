<?
/*
 * Clase que contiene las funciones para crear Social Plugins de facebook
 * relacionadas directamente a la pagina de facebook.
 */
class funcionesFace{

	/*
	 * Constructor: crea el script que maneja los eventos sobre los elementos de facebook
	 * 		Nota: se omitio la carga del JavaScript SDK dado que las funciones
	 *			implementadas no necesitan cargar el SDK para funcionar
	 *			correctamente, seria necesario en caso de querer usar el
	 *			plugins como el faceapile, aplicacion registrada en facebook, etc.
	 */
	function funcionesFace(){
	?>
		<div id="fb-root"></div>
		<script>
			(
			function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id))
					return;
				js = d.createElement(s);
				js.id = id;
				js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1";
				fjs.parentNode.insertBefore(js, fjs);
			}
			(document, 'script', 'facebook-jssdk')
			);
		</script>	
	<?
	} // fin de funcion doLikeDiv
	
	/*
	 * Agrega el boton like
	 * $p_dir -> direccion a la que se le dara like
	 */
	function doLikeButton($p_dir){
		echo '<div class="fb-like" data-href="'. $p_dir .'" data-width="300" data-layout="standard" data-action="like" data-show-faces="true" data-share="false"></div>';
	}
	
	/*
	 * crea la capa donde apareceran los comentarios del facebook
	 * $p_commentTarget -> direccion URL que sera comentada
	 * 			En esta version, no se cuenta con una independencia de perfiles, por
	 *			lo tanto, todos los usuarios seran capaces de ver los comentarios
	 *
	 * referencia futura: la pagina recibida debera ser del tipo perfil.php?id=id_usuario
	 * 			De esta manera, los comentarios seran asociados unicamente al perfil
	 *			del usuario perteneciente a la sesion
	 */
	function doCommentDiv($p_commentTarget){
		echo '<div class="fb-comments" data-href="'. $p_commentTarget .'" data-width="350" data-numposts="3" data-colorscheme="light"></div>';
	}

	/*
	 * crea el boton de seguir en facebook
	 * $p_fbUser -> nombre de usuario de facebook
	 * 		Restriccion: El usuario debe tener activada la opcion de "permitir seguidores"
	 *				en la configuracion de su facebook
	 */
	function doFollowButton($p_fbUser){
		echo '<div class="fb-follow" data-href="http://www.facebook.com/'. $p_fbUser .'" data-width="100" data-colorscheme="light" data-layout="standard" data-show-faces="true"></div>';

//echo '<iframe src="//www.facebook.com/plugins/follow?href=https%3A%2F%2Fwww.facebook.com%' .$p_fbUser. '&amp;layout=standard&amp;show_faces=true&amp;colorscheme=light&amp;width=450&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:80px;" allowTransparency="true"></iframe>';
	}

} // fin de clase

?>
