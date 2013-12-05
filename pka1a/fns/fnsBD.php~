<?
class bd{
	// Aributos
	var $a_mensError;
	var $a_bandError;
	var $a_numRegistros;
	var $a_conexion;
	var $a_resuConsulta;

	// Constructor
	function bd($p_servidor, $p_usuario, $p_cpassword){
		$this->m_abrir($p_servidor, $p_usuario, $p_cpassword);
	}

	// Abrir conexion
	function m_abrir($p_servidor, $p_usuario, $p_cpassword){
		$this->a_conexion = mysql_connect($p_servidor, $p_usuario, $p_cpassword);
		if(mysql_error() > "")
			$this->a_bandError=true;
		else
			$this->a_bandError=false;
	}

	// Seleccionar la base de datos
	function m_seleBD($p_nombBD){
		mysql_select_db($p_nombBD, $this->a_conexion);
	}
	
	// Realiza consulta en BD
	function m_consulta($p_query){
		$this->a_resuConsulta = mysql_query($p_query);
		$this->a_mensError=mysql_error();	// si no hay error, se asigna cadena vacía a a_error
		if($this->a_mensError > "")
			$this->a_bandError = true;
		else{
			$this->a_bandError = false;
			$this->a_numRegistros = mysql_num_rows($this->a_resuConsulta);
		}
	}

} // Termina clase

?>
