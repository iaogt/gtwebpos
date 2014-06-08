<?php
	/**
	 * Este script configura Doctrine (ya instalado en el servidor) para poder utilizarlo en la aplicación como capa de datos
	 * NOTA:  Necesita incluirse appConf.php antes de este script para poder acceder a la clase Configuracion
	 * */
	require_once 'Doctrine.php';
	require_once 'conf.php';
	
	spl_autoload_register(array('Doctrine', 'autoload'));
	$manager = Doctrine_Manager::getInstance();
	$manager->setAttribute(Doctrine::ATTR_MODEL_LOADING, Doctrine::MODEL_LOADING_AGGRESSIVE);		//para que cargue los modelos conforme se vayan utilizando y así ahorrar memoria
	
	$dsn = BDConfiguracion::DSN();
	$conn = Doctrine_Manager::connection($dsn['phptype'].'://'.$dsn['username'].':'.$dsn['password'].'@'.$dsn['hostspec'].'/'.$dsn['database']);		
	Doctrine::loadModels(dirname(__FILE__).'/data/modelos/');	//Carpeta en la cual busca los archivos de definición de modelo
?>