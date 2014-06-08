<?php
require_once ('aplicacion/Componente.php');

/**
 * Base para las aplicaciones.
 * @version 1.0
 * @created 17-Jun-2008 05:32:11 p.m.
 */
class Base extends Componente
{
	/**
	 * Al iniciar se agregan los valores de la configuración
	 * */
	function __construct(){
		parent::__construct();
	}


	/**
	 * Devuelve el objeto tpl
	 * */
	public function get(){
        return $this->tpl->get();
	}

	/**
	 * Devuelve el html ya armado
	 * **/
	public function show()
	{
		$txt="";
		if($this->_loaded)
			$txt=$this->tpl->get();
		return $txt;
	}
	
	
	/**
	 * Devuelve la referencia al objeto tpl
	 * **/
	public function compose(){
		return $this->getTpl();
	}

}
?>