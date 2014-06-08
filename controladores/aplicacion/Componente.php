<?php

require_once ('HTML/Template/Sigma.php');

/**
 * es la clase encargada de manejar la conexión a la base de datos y valores de
 * configuración para toda la aplicación
 * @version 1.0
 * @created 17-Jun-2008 05:32:13 p.m.
 */
abstract class Componente
{

	var $m_Configuracion;
	var $_commAttr;
	var $_loaded;

	function __construct()
	{
		$this->tpl=new HTML_Template_Sigma();
		$this->_loaded=FALSE;
		$this->_commAttr=array();
	}
	
	/**
	 * Carga la plantilla al objeto
	 * @param strTplFile
	 */
	public function assign_template($strTplFile){
		$res=$this->tpl->loadTemplateFile($strTplFile);		
		if(!PEAR::isError($res))
			$this->_loaded=TRUE;
	}
	
	/**
	 * Inserta el contenido
	 * */
	protected function insert_content($strPHName,$strContent){
		$this->tpl->setVariable($strPHName,$strContent);
	}

	protected function getTpl(){
		return $this->tpl;
	}
	
	/**
	 * Guarda los valores comunes
	 * @ attName : nombre de la propiedad común, puede ser array del tipo [nombre,valor]
	 * @ value   : valor de la propiedad común 
	 * */
	public function setCommonAttr($attrName, $value=null){
		if(is_array($attrName)){
			$this->_commAttr=$attrName;
		}else{
			$this->_commAttr[$attrName]=$value;
		}
	}
	
	
	/**
	 * Devuelve los atributos comunes
	 * */
	protected function getCommonAttr(){
		return $this->_commAttr;
	}

	public abstract function show();

}
?>