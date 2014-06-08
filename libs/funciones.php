<?php
	/**
	 * Verifica si el usuario ya está logeado
	 * */
	function verificaLogin(){
		if((!isset($_SESSION['userid']))||($_SESSION['userid']<0)){		//Si no existe o si el valor es inválido
			header('Location: login.php');
		}
	}

?>