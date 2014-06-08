<?php
	require_once('aplicacion/Modulo.php');
	
	class Pagina extends Modulo {
		function __construct($objCompound=NULL,$strPHName=NULL){
			parent::__construct($objCompound,$strPHName);
		}

		protected function exec(){
			$a=1;
		}
	}
?>