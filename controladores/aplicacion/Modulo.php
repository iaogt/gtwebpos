<?php
require_once ('aplicacion/Componente.php'); 

/**
 * permite extender la funcionalidad de la base
 * @version 1.0
 * @updated 17-Jun-2008 05:44:40 p.m.
 */
abstract class Modulo extends Componente
{

	var $compound;
	var $placeholder;
	/*
	*	objCompound		Objeto al que compone
	*	objPos			Nombre del placeholder en la plantilla donde se inserta el HTML de este objeto
	*/
	function __construct($objCompound=null,$strPHName="")
	{
    	parent::__construct();		
		$this->compound=$objCompound;		
		$this->placeholder=$strPHName;
		$this->_commAttr=($objCompound!=null) ? $objCompound->getCommonAttr() : array();	//Las variables que fueron declaradas como comunes en el objeto anterior
	}
	
	/**
	 * Compone los objetos que se envolvieron
	 * */
	private function compose(){
		if($this->compound!=null){			//If it's wrapping an object
			$this->parse_common();
			$txtTmp=$this->tpl->get();
			$this->tpl=$this->compound->compose();
			$this->tpl->setVariable($this->placeholder,$txtTmp);
			$compoundElements=$this->compound->getCommonAttr();
			if(is_array($compoundElements)){
				$this->_commAttr=array_merge($this->_commAttr,$compoundElements);
			}
		}
		return $this->tpl;
	}
	
	/**
	 * Asigna el valor de las variables comunes
	 * */
	private function parse_common(){
		foreach($this->_commAttr as $_var=>$val){
			if(is_array($val)){
				$txt=implode("\n",$val);
			}
			else
				$txt=$val;
			$this->tpl->setVariable($_var,$txt);
		}
	}
	
    /*function setCommonVars($attrName,$value){
		$this->_commAttr[$attrName]=$value;    
        //$this->tpl->setVariable($global_arrGeneral);
    }*/

	public function show(){
		$this->compose();		//Inherits all the values from the inner objects
		$this->parse_common();
		$texto=$this->tpl->get();
		return $texto;
	}
}
?>